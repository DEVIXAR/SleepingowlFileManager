<?php
namespace Devixar\SleepingowlFileManager\Commands;

use Devixar\SleepingowlFileManager\Helpers\PackHelper;
use Illuminate\Console\Command;
use Mockery\CountValidator\Exception;

class PublishCommand extends Command
{
    /*
     * Terminal command signature
     */
    protected $signature = 'sofmanager:publish';

    /*
     * Description command
     */
    protected $description = 'publish Sleepingowl File Manager package.';

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

        $this->info('Sleepingowl file manager publish');

        // install sleepingowl admin
        $this->call('sleepingowl:install');
        $this->info('Install sleepingowl admin:.........success');

        // publish
        // // publish
        $this->call('vendor:publish');

        // migrations
        $this->call('migrate');

        // needed files
        $this->helper->makeDir(app_path('Admin/resources'));
        if(!$this->helper->isFile(app_path('Admin/resources/assets.php')))
        {
            $this->helper->replaceAndSaveFile(__DIR__ . '/../Admin/resources/assets.stub', '', '', app_path('Admin/resources/assets.php'));
        }
        $this->helper->makeDir(resource_path('views/vendor/sleeping_owl/default/_layout/'));

        // add modal for manager
        $sleepingowlLayoutPath = resource_path('views/vendor/sleeping_owl/default/_layout/base.blade.php');
        if(!$this->helper->isFile($sleepingowlLayoutPath))
        {
            $this->helper->replaceAndSaveFile(
                __DIR__ . '/../Admin/views/layouts/base.blade.stub',
                '{{LARADROP_MODAL}}',
                $this->helper->getFileContent(__DIR__ . '/../Admin/views/laradrop_modal.blade.stub'),
                $sleepingowlLayoutPath
                );
        } else if(!$this->helper->isStringInFile($sleepingowlLayoutPath, 'LARADROP_MODAL')) {
            $this->helper->replaceAndSaveFile(
                $sleepingowlLayoutPath,
                "@yield('content')",
                PHP_EOL .
                $this->helper->getFileContent(__DIR__ . '/../Admin/views/laradrop_modal.blade.stub')
                    . PHP_EOL . PHP_EOL ."@yield('content')" . PHP_EOL
            );
        }

        // laradrop set path
        $this->helper->replaceAndSaveFileList(
            config_path('laradrop.php'),
            [
                "'LARADROP_DISK_PUBLIC_URL', ''" => "'LARADROP_DISK_PUBLIC_URL', '/images/uploads/'",
                "'LARADROP_DISK', 'local'" => "'LARADROP_DISK', 'laradrop'"
            ],
            config_path('laradrop.php')
        );

        // add laradrop file system
        if(!$this->helper->isStringInFile(config_path('filesystems.php'), "laradrop")) {
            $this->helper->replaceAndSaveFile(
                config_path('filesystems.php'),
                "'disks' => [",
                "'disks' => [" .
                PHP_EOL .
                PHP_EOL . "        'laradrop' => [" .
                PHP_EOL . "            'driver' => 'local'," .
                PHP_EOL . "            'root' => public_path('/images/uploads')," .
                PHP_EOL . "        ],",
                config_path('filesystems.php')
            );
        }

        // add forms
        $this->helper->makeDir(app_path('Admin/form'));

        // // image manager
        $this->helper->replaceAndSaveFile(
            __DIR__ . '/../Admin/form/ImageManager.stub', '', '',
            app_path('Admin/form/ImageManager.php')
        );

        // // file manager
        $this->helper->replaceAndSaveFile(
            __DIR__ . '/../Admin/form/FileManager.stub', '', '',
            app_path('Admin/form/FileManager.php')
        );

        $this->info('Pablished:.........................success');
    }
}