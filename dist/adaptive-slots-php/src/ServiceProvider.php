<?php

namespace MisterChameleon\AdaptiveSlots;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    /**
     * Tags registered by this addon.
     * Statamic derives the handle from the class's static $handle ("mc"),
     * so templates use {{ mc:slot }}.
     */
    protected $tags = [
        Tags\MisterChameleon::class,
    ];

    public function bootAddon()
    {
        // Merge package defaults so config('mister-chameleon.*') always resolves.
        $this->mergeConfigFrom(__DIR__.'/../config/mister-chameleon.php', 'mister-chameleon');

        // Allow the host site to publish and override the config:
        //   php artisan vendor:publish --tag=mister-chameleon-config
        $this->publishes([
            __DIR__.'/../config/mister-chameleon.php' => config_path('mister-chameleon.php'),
        ], 'mister-chameleon-config');
    }
}
