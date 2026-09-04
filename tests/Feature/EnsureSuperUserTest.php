<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Hash;
use Statamic\Facades\User;
use Tests\TestCase;

/**
 * mc:ensure-super-user runs on every deploy, so what matters most is that it is
 * genuinely idempotent — and that it never fails the deploy.
 *
 * Users are flat files (config/statamic/users.php → repository "file"), so each
 * test cleans up after itself rather than relying on a database rollback.
 */
class EnsureSuperUserTest extends TestCase
{
    private const EMAIL = 'demo+phpunit@misterchameleon.nl';

    protected function tearDown(): void
    {
        if ($user = User::findByEmail(self::EMAIL)) {
            $user->delete();
        }

        putenv('CP_ADMIN_EMAIL');
        putenv('CP_ADMIN_PASSWORD');
        unset($_ENV['CP_ADMIN_EMAIL'], $_ENV['CP_ADMIN_PASSWORD'], $_SERVER['CP_ADMIN_EMAIL'], $_SERVER['CP_ADMIN_PASSWORD']);

        parent::tearDown();
    }

    private function setCpAdminEnv(string $email, string $password = 'a-generated-password'): void
    {
        putenv("CP_ADMIN_EMAIL={$email}");
        putenv("CP_ADMIN_PASSWORD={$password}");
        $_ENV['CP_ADMIN_EMAIL']    = $email;
        $_ENV['CP_ADMIN_PASSWORD'] = $password;
    }

    public function test_it_creates_a_super_user_from_the_environment(): void
    {
        $this->setCpAdminEnv(self::EMAIL);

        $this->artisan('mc:ensure-super-user')->assertExitCode(0);

        $user = User::findByEmail(self::EMAIL);
        $this->assertNotNull($user, 'expected the super-user to be created');
        $this->assertTrue($user->isSuper(), 'expected the created user to be a super-user');
    }

    public function test_it_is_a_no_op_when_no_credentials_are_set(): void
    {
        $this->artisan('mc:ensure-super-user')->assertExitCode(0);

        $this->assertNull(User::findByEmail(self::EMAIL));
    }

    public function test_it_is_a_no_op_when_only_one_half_is_set(): void
    {
        putenv('CP_ADMIN_EMAIL='.self::EMAIL);
        $_ENV['CP_ADMIN_EMAIL'] = self::EMAIL;

        $this->artisan('mc:ensure-super-user')->assertExitCode(0);

        $this->assertNull(User::findByEmail(self::EMAIL));
    }

    public function test_running_it_twice_leaves_the_existing_user_untouched(): void
    {
        // This is the case that actually happens: the command is in the deploy
        // commands, so it runs again on every single deploy.
        $this->setCpAdminEnv(self::EMAIL, 'first-password');
        $this->artisan('mc:ensure-super-user')->assertExitCode(0);
        $first = User::findByEmail(self::EMAIL);
        $this->assertNotNull($first);

        // A second run with a DIFFERENT password must not reset the account —
        // an operator who changed it in the CP would otherwise lose that change
        // on the next deploy.
        $this->setCpAdminEnv(self::EMAIL, 'second-password');
        $this->artisan('mc:ensure-super-user')->assertExitCode(0);

        $again = User::findByEmail(self::EMAIL);
        $this->assertNotNull($again);
        $this->assertSame($first->id(), $again->id(), 'expected the same user, not a replacement');
        $this->assertTrue(
            Hash::check('first-password', $again->password()),
            'expected the original password to survive the second run',
        );
        $this->assertFalse(
            Hash::check('second-password', $again->password()),
            'the second run must not have reset the password',
        );
    }

    public function test_an_invalid_email_is_skipped_rather_than_failing_the_deploy(): void
    {
        $this->setCpAdminEnv('not-an-email');

        $this->artisan('mc:ensure-super-user')->assertExitCode(0);

        $this->assertNull(User::findByEmail('not-an-email'));
    }
}
