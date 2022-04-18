<?php

namespace LaraEditor;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\URL;

class LaraEditorServiceProvider extends ServiceProvider
{
    public $routeFilePath = '/routes/laraeditor.php';

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views/'), 'laraeditor');
        $this->mergeConfigFrom(__DIR__.'/config.php', 'laraeditor');

        $this->setupRoutes($this->app->router);

        if ($this->app->runningInConsole()) {
            $this->publishFiles();            
        }
        
        $this->updateFileManagerConfig();
    }

    public function updateFileManagerConfig()
    {
        config()->set('file-manager.diskList',[config('laraeditor.assets.disk')]);
        config()->set('file-manager.leftPath',config('laraeditor.assets.path'));
        config()->set('file-manager.rightPath',config('laraeditor.assets.path'));
        config()->set('cors.paths',array_merge(config('cors.paths'),['file-manager/*']));
        // config()->set('cors.paths',array_merge(config('cors.paths'),['file-manager/*']));
    }


    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        // by default, use the routes file provided in vendor
        $routeFilePathInUse = __DIR__.$this->routeFilePath;

        // but if there's a file with the same name in routes/backpack, use that one
        if (file_exists(base_path().$this->routeFilePath)) {
            $routeFilePathInUse = base_path().$this->routeFilePath;
        }

        $this->loadRoutesFrom($routeFilePathInUse);
    }

    public function publishFiles()
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('laraeditor.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../dist' => public_path().'/vendor/laravel-editor',
        ], 'public');
    }
}
