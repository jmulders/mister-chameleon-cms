<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    |
    | Whether the API should be enabled, and through what route. You
    | can enable or disable the whole API, and expose individual
    | resources per environment, depending on your site needs.
    |
    | https://statamic.dev/content-api#enable-the-api
    |
    */

    'enabled' => env('STATAMIC_API_ENABLED', false),

    // Read by the Next.js platform (Vercel) via STATAMIC_API_URL.
    // Users and forms stay disabled — never expose those publicly.
    'resources' => [
        // The Next.js platform looks up entries by slug
        // (?filter[slug:is]=home&limit=1). Statamic disables filtering by
        // default, so we must opt in via allowed_filters — otherwise those
        // lookups return nothing and pages fail to load over the API.
        // The `*` wildcard enables every collection with slug/title/status
        // filtering in one shot.
        'collections' => [
            '*' => [
                'enabled' => true,
                'allowed_filters' => ['slug', 'title', 'status', 'id'],
            ],
        ],
        'navs' => true,
        'taxonomies' => true,
        'assets' => true,
        'globals' => true,
        'forms' => false,
        'users' => false,
    ],

    'route' => env('STATAMIC_API_ROUTE', 'api'),

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    |
    | By default, the API will be publicly accessible. However, you may define
    | an API token here which will be used to authenticate requests.
    |
    */

    'auth_token' => env('STATAMIC_API_AUTH_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | Define the middleware / middleware group that will be applied to the
    | API route group. If you want to externally expose this API, here
    | you can configure a middleware-based authentication layer.
    |
    */

    'middleware' => env('STATAMIC_API_MIDDLEWARE', 'api'),

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | The numbers of items to show on each paginated page.
    |
    */

    'pagination_size' => 50,

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | By default, Statamic will cache each endpoint until the specified
    | expiry, or until content is changed. See the documentation for
    | more details on how to customize your cache implementation.
    |
    | https://statamic.dev/content-api#caching
    |
    */

    'cache' => [
        'expiry' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Exclude Keys
    |--------------------------------------------------------------------------
    |
    | Here you may provide an array of keys to be excluded from API responses.
    | For example, you may want to hide things like edit_url, api_url, etc.
    |
    */

    'excluded_keys' => [
        //
    ],

];