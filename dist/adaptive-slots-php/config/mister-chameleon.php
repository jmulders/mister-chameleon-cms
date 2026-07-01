<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site key
    |--------------------------------------------------------------------------
    | Your site key from the Mister Chameleon dashboard (Setup → Snippet).
    | Without it the {{ mc:slot }} tag renders only the author's fallback content.
    */
    'site_key' => env('MC_SITE_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Platform URL
    |--------------------------------------------------------------------------
    | Base URL of the Mister Chameleon platform that serves /api/snippet/decide.
    */
    'platform_url' => env('MC_PLATFORM_URL', 'https://app.misterchameleon.com'),

    /*
    |--------------------------------------------------------------------------
    | Decision timeout (seconds)
    |--------------------------------------------------------------------------
    | The tag fails open: if the platform does not respond within this window the
    | author's fallback content is rendered, so a slow/unavailable platform never
    | blocks or breaks the page.
    */
    'timeout' => env('MC_DECIDE_TIMEOUT', 2),

    /*
    |--------------------------------------------------------------------------
    | Decision cache TTL (seconds)
    |--------------------------------------------------------------------------
    | Optional short-lived cache for the decide response. 0 = disabled (default).
    | The cache key includes the full visitor context (path, UTM, mc_session_id,
    | locale), and the session id is per visitor, so one visitor's personalised
    | result is never served to another. A small value (e.g. 30-60) absorbs
    | bursts (a visitor reloading the same page) without staleness concerns.
    */
    'cache_ttl' => env('MC_DECIDE_CACHE_TTL', 0),

];
