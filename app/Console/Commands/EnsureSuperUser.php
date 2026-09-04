<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Statamic\Facades\User;

/**
 * Create the demo/admin super-user from the environment, if it isn't there yet.
 *
 * A provisioned instance has no users at all: Statamic stores them as flat files
 * in users/, which the template doesn't ship, so a fresh rollout lands on a CP
 * login screen nobody can get past. The provisioner injects CP_ADMIN_EMAIL and a
 * generated CP_ADMIN_PASSWORD as Ploi secrets, and this command turns them into
 * an actual account on deploy.
 *
 * Fully idempotent, so it is safe in the deploy commands and runs on EVERY
 * deploy — which is what makes it work at all: the container filesystem is
 * ephemeral, so a user file created by hand would vanish on the next deploy.
 *
 * Idempotent in three senses:
 *   - no credentials in the environment      → nothing to do, exit 0
 *   - a user with that email already exists  → left exactly as-is, exit 0
 *     (deliberately does NOT reset the password: an operator who changed it in
 *     the CP would otherwise have it silently reverted on every deploy)
 *   - otherwise                              → create it, super, exit 0
 *
 * Never fails the deploy. A rollout that cannot create the user is still a
 * working site; the operator gets a warning in the deploy log instead.
 */
class EnsureSuperUser extends Command
{
    protected $signature = 'mc:ensure-super-user';

    protected $description = 'Create the super-user from CP_ADMIN_EMAIL / CP_ADMIN_PASSWORD if it does not exist yet.';

    public function handle(): int
    {
        $email    = trim((string) env('CP_ADMIN_EMAIL', ''));
        $password = (string) env('CP_ADMIN_PASSWORD', '');

        if ($email === '' || $password === '') {
            $this->line('mc:ensure-super-user: CP_ADMIN_EMAIL / CP_ADMIN_PASSWORD not set — nothing to do.');

            return self::SUCCESS;
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->warn("mc:ensure-super-user: CP_ADMIN_EMAIL ({$email}) is not a valid address — skipped.");

            return self::SUCCESS;
        }

        try {
            if (User::findByEmail($email)) {
                $this->line("mc:ensure-super-user: {$email} already exists — left unchanged.");

                return self::SUCCESS;
            }

            User::make()
                ->email($email)
                ->makeSuper()
                ->password($password)
                ->save();

            $this->info("mc:ensure-super-user: created super-user {$email}.");
        } catch (\Throwable $e) {
            // Never break a deploy over this — the site still works without a CP
            // login, and the operator can retry or add the user by hand.
            $this->warn('mc:ensure-super-user: could not create the user — '.$e->getMessage());
        }

        return self::SUCCESS;
    }
}
