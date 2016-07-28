# Sleepingowl File Manager v0.0.1

## Install

Via Composer

``` bash
$ composer require devixar/sleepingowl-file-manager
```

## config/app.php providers array

``` php
/*
* Sleepingowl File Manager
*/
Devixar\SleepingowlFileManager\SleepingowlFileManagerServiceProvider::class,
```

## Via artisan
``` bash
$ artisan sofmanager:install
$ artisan sofmanager:publish
```

## Setting
You can change path for load files: 
``` php
    // app/config/filesystems.php 
    
    'laradrop' => [
        'driver' => 'local',
        'root' => public_path('/images/uploads'), // path for save files
    ],
```

You can change path from get thumbnail:
``` php
    // app/config/laradrop.php 
    
    'disk_public_url' => env('LARADROP_DISK_PUBLIC_URL', '/images/uploads/'),
```

## Problems
If you use `Debugbar` you can get console error.
For fix set `'capture_ajax' => false` in app/config/debugbar.php

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
