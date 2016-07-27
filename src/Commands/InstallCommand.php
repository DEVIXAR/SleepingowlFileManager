<?php
namespace Devixar\SleepingowlFileManager\Commands;

use Devixar\SleepingowlFileManager\Helpers\PackHelper;
use Illuminate\Console\Command;
use Mockery\CountValidator\Exception;

class InstallCommand extends Command
{
    protected $signature = 'sofmanager:install';

    protected $description = 'Install Sleepingowl File Manager package.';

    protected $helper;

    public function __construct(PackHelper $helper)
    {
        parent::__construct();
        $this->helper = $helper;
    }

    public function handle()
    {

        // check laravel version
        $laravelVersionSuccess = $this->helper->checkLaravelVersion($this->getLaravel()->version());
        $this->info('Check laravel version:.............' . $this->helper->beatybool($laravelVersionSuccess));
        if(!$laravelVersionSuccess) {
            throw new Exception('Laravel version(' . $this->getLaravel()->version() . ') is\'t correct. Valid are/is ' . $this->helper->getValidLaravelVersionLine());
        }

        // check sleeping owl
        $sleepingowlIsset = $this->helper->checkExistingPackage('laravelrus', 'sleepingowl');
        $this->info('Check installed Sleepingowl:.......' . $this->helper->beatybool($sleepingowlIsset));
        if(!$sleepingowlIsset) {
            $this->error('You need install Sleepingowl. For install use: composer require "laravelrus/sleepingowl":"4.*@dev"');
            $this->error('Or visit: http://sleepingowl.laravel.su/docs/4.0/installation');
        }
        
//        $this->line('New world!', 'comment');

//        if($this->ask('Do you want to clear cache?', 'Y') == 'Y') {
//            $this->call('cache:clear');
//        }

//        throw new Exception('Error yo!');

//        $composer = json_decode(file_get_contents('composer.json'), true);
//        foreach ($composer['autoload']['psr-4'] as $package => $path) {
//            if($package !== 'App\\') {
//                $packages[] = [rtrim($package, '\\'), $path];
//            }
//        }

//        $headers = ['Package', 'Path'];
//        $this->table($headers, $packages);
    }
}