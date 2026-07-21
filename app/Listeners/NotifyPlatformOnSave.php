<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Http;
use Statamic\Events\EntrySaved;

/**
 * On every Statamic entry save, ping the Mister Chameleon platform webhook so it
 * flushes its Next.js content cache (revalidateTag) — making the change live
 * immediately instead of after the cache TTL.
 *
 * Requires two env vars:
 *   MISTER_CHAMELEON_API_URL         e.g. https://www.misterchameleon.nl
 *   MISTER_CHAMELEON_WEBHOOK_SECRET  the x-statamic-secret configured on the platform
 *
 * Fully wrapped — a failure here can never break a content save.
 */
class NotifyPlatformOnSave
{
    public function handle(EntrySaved $event): void
    {
        $base   = rtrim((string) env('MISTER_CHAMELEON_API_URL', ''), '/');
        $secret = (string) env('MISTER_CHAMELEON_WEBHOOK_SECRET', '');

        if ($base === '' || $secret === '') {
            return;
        }

        try {
            Http::timeout(5)
                ->withHeaders(['x-statamic-secret' => $secret])
                ->post($base.'/api/webhooks/cms/statamic', [
                    'event'      => 'EntrySaved',
                    'collection' => optional($event->entry->collection())->handle(),
                    'entries'    => [],
                ]);
        } catch (\Throwable $e) {
            // Non-fatal: never break a save because the platform is unreachable.
            report($e);
        }
    }
}
