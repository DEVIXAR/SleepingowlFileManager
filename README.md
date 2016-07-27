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

## Problems
If you use `Debugbar` you can get console error.
For fix set `'capture_ajax' => false` in app/config/debugbar.php

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
