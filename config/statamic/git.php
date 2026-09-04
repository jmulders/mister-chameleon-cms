<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Git Integration
    |--------------------------------------------------------------------------
    |
    | Whether Statamic's git integration should be enabled. This feature
    | assumes that git is already installed and accessible by your
    | PHP process' server user. For more info, see the docs at:
    |
    | https://statamic.dev/git-automation
    |
    */

    'enabled' => env('STATAMIC_GIT_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Automatically Run
    |--------------------------------------------------------------------------
    |
    | By default, commits are automatically queued when `Saved` or `Deleted`
    | events are fired. If you prefer users to manually trigger commits
    | using the `Git` utility interface, you may set this to `false`.
    |
    | https://statamic.dev/git-automation#committing-changes
    |
    */

    'automatic' => env('STATAMIC_GIT_AUTOMATIC', true),

    /*
    |--------------------------------------------------------------------------
    | Queue Connection
    |--------------------------------------------------------------------------
    |
    | You may choose which queue connection should be used when dispatching
    | commit jobs. Unless specified, the default connection will be used.
    |
    | https://statamic.dev/git-automation#queueing-commits
    |
    */

    'queue_connection' => env('STATAMIC_GIT_QUEUE_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Dispatch Delay
    |--------------------------------------------------------------------------
    |
    | When `Saved` and `Deleted` events queue up commits, you may wish to
    | set a delay time in minutes for each queued job. This can allow
    | for more consolidated commits when you have multiple users
    | making simultaneous content changes to your repository.
    |
    | Note: Not supported by default `sync` queue driver.
    |
    */

    'dispatch_delay' => env('STATAMIC_GIT_DISPATCH_DELAY', 0),

    /*
    |--------------------------------------------------------------------------
    | Git User
    |--------------------------------------------------------------------------
    |
    | The git user that will be used when committing changes. By default, it
    | will attempt to commit with the authenticated user's name and email
    | when possible, falling back to the below user when not available.
    |
    | https://statamic.dev/git-automation#git-user
    |
    */

    'use_authenticated' => true,

    'user' => [
        'name' => env('STATAMIC_GIT_USER_NAME', 'Spock'),
        'email' => env('STATAMIC_GIT_USER_EMAIL', 'spock@example.com'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Tracked Paths
    |--------------------------------------------------------------------------
    |
    | Define the tracked paths to be considered when staging changes. Default
    | stache and file locations are already set up for you, but feel free
    | to modify these paths to suit your storage config. Referencing
    | absolute paths to external repos is also completely valid.
    |
    | CONTENT ONLY — never the platform-managed code. `resources/blueprints`,
    | `resources/fieldsets` and `resources/addons` are owned by the platform
    | (regenerated from the manifest by `php please mc:sync`, shipped via PRs).
    | If the CP git-automation committed them, a drifted/stale fieldset would be
    | pushed back → the CP strips `type` from replicator items on save → corrupts
    | content and breaks the live preview. So they are deliberately EXCLUDED here;
    | only content + CP-authored forms are versioned. See DEPLOY.md.
    |
    */

    'paths' => [
        base_path('content'),
        base_path('users'),
        resource_path('forms'),               // CP-authored Statamic forms (e.g. locatie-test)
        resource_path('users'),
        resource_path('preferences.yaml'),    // CP preferences (per-instance, harmless)
        storage_path('forms'),                // form submissions
        public_path('assets'),
        // NOT tracked — platform-managed (PR + `php please mc:sync` authoritative):
        //   resource_path('addons'), resource_path('blueprints'), resource_path('fieldsets')
        // NOT tracked — env-derived per deploy (deploy.sh rewrites the URL):
        //   resource_path('sites.yaml')
    ],

    /*
    |--------------------------------------------------------------------------
    | Git Binary
    |--------------------------------------------------------------------------
    |
    | By default, Statamic will try to use the "git" command, but you can set
    | an absolute path to the git binary if necessary for your environment.
    |
    */

    'binary' => env('STATAMIC_GIT_BINARY', 'git'),

    /*
    |--------------------------------------------------------------------------
    | Commands
    |--------------------------------------------------------------------------
    |
    | Define a list commands to be run when Statamic is ready to `git add`
    | and `git commit` your changes. These commands will be run once
    | per repo, attempting to consolidate commits where possible.
    |
    | https://statamic.dev/git-automation#customizing-commits
    |
    | The final push targets a DISPOSABLE, CP-owned branch (`cms-content`), never
    | `main`. `main` is written only by PRs (platform code + reviewed content), so a
    | CP "Content saved" push can never overwrite / force-remove a PR-merged commit
    | on `main` (which is what happened to the locatie-test entry before this fix).
    | The push is `--force` on purpose: `cms-content` is a throwaway snapshot branch
    | with exactly one writer (this container), so there is nothing to clobber — the
    | deploy rebuilds it from the current `main` tip on every run. `deploy.sh` then
    | overlays that branch's content paths onto the deployed tree. See DEPLOY.md.
    |
    */

    'commands' => [
        '{{ git }} add {{ paths }}',
        '{{ git }} -c "user.name={{ name }}" -c "user.email={{ email }}" commit -m "{{ message }}"',
        '{{ git }} push --force origin HEAD:refs/heads/'.env('STATAMIC_GIT_CONTENT_BRANCH', 'cms-content'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Push
    |--------------------------------------------------------------------------
    |
    | Determine whether `git push` should be run after the commands above
    | have finished.
    |
    | HARDCODED `false` on purpose. Statamic's built-in push targets the CURRENT
    | branch's upstream (i.e. `main` on the container) — exactly the push-back that
    | clobbered `main`. We instead push explicitly to the disposable `cms-content`
    | branch in `commands` above. Leaving this env-driven was a footgun: setting
    | `STATAMIC_GIT_PUSH=true` (as the old setup did) would re-enable the push to
    | `main` alongside our `cms-content` push. Do NOT set it back to env/true.
    |
    | https://statamic.dev/git-automation#pushing-changes
    |
    */

    'push' => false,

    /*
    |--------------------------------------------------------------------------
    | Ignored Events
    |--------------------------------------------------------------------------
    |
    | Statamic will listen on all `Saved` and `Deleted` events, as well
    | as any events registered by installed addons. If you wish to
    | ignore any specific events, you may reference them here.
    |
    */

    'ignored_events' => [
        // \Statamic\Events\UserSaved::class,
        // \Statamic\Events\UserDeleted::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Locale
    |--------------------------------------------------------------------------
    |
    | The locale to be used when translating commit messages, etc. By
    | default, the authenticated user's locale will be used, but
    | feel free to override this using the provided variable.
    |
    */

    'locale' => env('STATAMIC_GIT_LOCALE', null),

];
