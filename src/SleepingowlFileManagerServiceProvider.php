<?php

namespace Devixar\SleepingowlFileManager;

use Illuminate\Support\ServiceProvider;

class SleepingowlFileManagerServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // register routes
        require __DIR__ . '/Http/routes.php';

        $this->publishes([
            __DIR__ . '/public' => public_path('vendor/devixar/sofmanager')
        ], 'public');

        $this->publishes([
            __DIR__ . '/Admin/views/forms' => resource_path('/views/vendor/sleeping_owl/default/forms')
        ], 'views');
        
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();

        // init forms
        if(class_exists(\SleepingOwl\Admin\Admin::class))
        {
            \AdminFormElement::add('imagemanager', \App\Admin\Form\ImageManager::class);
            \AdminFormElement::add('filemanager', \App\Admin\Form\FileManager::class);
        }
    }

    protected function registerCommands()
    {
        $this->commands([
            \Devixar\SleepingowlFileManager\Commands\InstallCommand::class,
            \Devixar\SleepingowlFileManager\Commands\PublishCommand::class,
        ]);
    }
}