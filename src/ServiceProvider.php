<?php
namespace Arrounded\Assets;

use Arrounded\Assets\Commands\ReplaceAssets;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AssetsHandler::class, function ($app) {
            return new AssetsHandler($app['config']['assets']);
        });

        // Commands
        $this->app->bind('arrounded.assets.replace-assets', ReplaceAssets::class);
        $this->commands(['arrounded.commands.replace-assets']);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'arrounded.commands.replace-assets',
            AssetsHandler::class,
        ];
    }
}
