<?php
namespace Devixar\SleepingowlFileManager\Commands;

use Devixar\SleepingowlFileManager\Helpers\PackHelper;
use Illuminate\Console\Command;
use Mockery\CountValidator\Exception;

class InstallCommand extends Command
{
    /*
     * Terminal command signature
     */
    protected $signature = 'sofmanager:install';

    /*
     * Description command
     */
    protected $description = 'Install Sleepingowl File Manager package.';

    /*
     * Helper object
     */
    protected $helper;

    public function __construct(PackHelper $helper)
    {
        parent::__construct();
        $this->helper = $helper;
    }

    public function handle()
    {

        $this->info('Sleepingowl file manager installation');

        // check laravel version
        $laravelVersionSuccess = $this->helper->checkLaravelVersion($this->getLaravel()->version());
        $this->info('Check laravel version:.............' . $this->helper->beatybool($laravelVersionSuccess));
        if(!$laravelVersionSuccess)
        {
            throw new Exception('Laravel version(' . $this->getLaravel()->version() . ') is\'t correct. Valid are/is ' . $this->helper->getValidLaravelVersionLine());
        }

        // check sleeping owl
        $sleepingowlIsset = $this->helper->checkExistingPackage('laravelrus', 'sleepingowl');
        $this->info('Check installed Sleepingowl:.......' . $this->helper->beatybool($sleepingowlIsset));
        if(!$sleepingowlIsset)
        {
            $this->error('You need install Sleepingowl. For install use: composer require "laravelrus/sleepingowl":"4.*@dev"');
            $this->error('Or visit: http://sleepingowl.laravel.su/docs/4.0/installation');
        }

        // add service providers to app config
        $providers = PHP_EOL;
        if(!$isInstalledSleepingowl = $this->helper->checkAddedServiceProvider('SleepingOwl\Admin\Providers\SleepingOwlServiceProvider'))
        {
            $providers .= PHP_EOL . '       SleepingOwl\Admin\Providers\SleepingOwlServiceProvider::class,';
        }

        if(!$this->helper->checkAddedServiceProvider('Jasekz\Laradrop\LaradropServiceProvider'))
        {
            $providers .= PHP_EOL . '       Jasekz\Laradrop\LaradropServiceProvider::class,';
        }

        $this->helper->replaceAndSaveFile(
            getcwd().'/config/app.php',
            'App\Providers\RouteServiceProvider::class,',
            'App\Providers\RouteServiceProvider::class,' . ($providers != PHP_EOL ? $providers : '')
        );
        $this->info('Add service providers:.............success');

        $this->info('Install successful. Make `artisan sofmanager:publish`.');
    }
}