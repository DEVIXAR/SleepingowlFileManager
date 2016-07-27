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
        //
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();
    }

    protected function registerCommands()
    {
        $this->commands([
            \Devixar\SleepingowlFileManager\Commands\InstallCommand::class,
        ]);
    }
}