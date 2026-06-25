<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Statamic\Facades\CP\Nav;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ── Set-picker preview images ─────────────────────────────────────────
        //
        // On Ploi Cloud the `assets` container lives on a persistent volume that
        // shadows any preview images committed to git under public/assets. So we
        // ship them image-baked at public/set-previews/ and copy them into the
        // volume (public/assets/set-previews) at deploy time. Console-only, so it
        // runs during the deploy's artisan commands (cache:clear / stache:warm)
        // and never on a web request. Fully wrapped — a failure here can never
        // break the app or the deploy.
        if ($this->app->runningInConsole()) {
            $this->syncSetPreviewImages();
        }

        // ── Content Calendar — CP navigation item ─────────────────────────────
        //
        // Adds a "Contentkalender" link to the Statamic CP sidebar under the
        // "Content" section.  The route is defined in routes/web.php.
        Nav::extend(function ($nav) {
            $nav->content('Contentkalender')
                ->url('/cp/calendar')
                ->icon('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>');
        });
    }

    /**
     * Copy the image-baked set-picker previews into the assets volume.
     *
     * Source (read-only, in git): public/set-previews/*.png
     * Target (persistent volume):  public/assets/set-previews/*.png
     *
     * Copies a file only when it is missing or older at the target, so it is a
     * no-op after the first deploy. Never throws.
     */
    private function syncSetPreviewImages(): void
    {
        try {
            $src = public_path('set-previews');
            if (! is_dir($src)) {
                return;
            }

            $dest = public_path('assets/set-previews');
            if (! is_dir($dest)) {
                @mkdir($dest, 0775, true);
            }
            if (! is_dir($dest)) {
                return;
            }

            foreach (glob($src.'/*.png') ?: [] as $file) {
                $target = $dest.'/'.basename($file);
                if (! file_exists($target) || filemtime($file) > filemtime($target)) {
                    @copy($file, $target);
                }
            }
        } catch (\Throwable $e) {
            // Preview syncing must never break the app or a deploy.
            report($e);
        }
    }
}
