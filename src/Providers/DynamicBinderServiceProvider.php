<?php

namespace bobrovva\dynamic_binder_lib\Providers;

use Illuminate\Support\ServiceProvider;


class DynamicBinderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../DynamicBinderConditionResolver.php' => base_path('app/Infrastructure/DynamicBinder/DynamicBinderConditionResolver.php'),
            __DIR__.'/../config/bindings.php' => config_path('bindings.php'),
        ], 'dynamic-binder');
    }
}
