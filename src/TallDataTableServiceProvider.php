<?php

namespace Tanthammar\TallDataTable;

use Illuminate\Support\ServiceProvider;
use Tanthammar\TallDataTable\Commands\MakeTable;

/**
 * Class TallDataTableServiceProvider.
 */
class TallDataTableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([MakeTable::class]);
            $this->publishes([__DIR__ . '/../config/tall-data-table.php' => config_path('tall-data-table.php')], 'config');
            $this->publishes([__DIR__ . '/../resources/views' => resource_path('views/vendor/tall-data-table')], 'views');
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'tall-data-table');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/tall-data-table.php', 'tall-data-table');
    }
}
