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
}
