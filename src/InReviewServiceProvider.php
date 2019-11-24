<?php
/**
 * Created by iNiLabs.
 * Author: Rid Islam
 * Date: 2019-11-12
 * Time: 12:26
 */
namespace Ridislam\InReview;


use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;

class InReviewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->setupMigrations();
    }

    public function register()
    {
        $this->publishConfig();
    }

    /**
     * Publish config.
     */
    protected function publishConfig()
    {
        $source = realpath(__DIR__.'/../config/inreview.php');
        // Check if the application is a Laravel to properly merge the configuration file.
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('inreview.php')], 'inreview-config');
        }

        $this->mergeConfigFrom($source, 'inreview');
    }

    public function setupMigrations()
    {
        $this->publishes([
            realpath(__DIR__ . '/../database/migrations/') => database_path('migrations'),
        ], 'inreview-migrations');
    }
}
