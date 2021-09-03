<?php

declare(strict_types=1);

namespace Codeat3\BladeDevIcons;

use BladeUI\Icons\Factory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container;

final class BladeDevIconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('blade-devicons', []);

            $factory->add('devicons', array_merge(['path' => __DIR__.'/../resources/svg'], $config));
        });
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-devicons.php', 'blade-devicons');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/svg' => public_path('vendor/blade-devicons'),
            ], 'blade-devicons');

            $this->publishes([
                __DIR__.'/../config/blade-devicons.php' => $this->app->configPath('blade-devicons.php'),
            ], 'blade-devicons-config');
        }
    }
}
