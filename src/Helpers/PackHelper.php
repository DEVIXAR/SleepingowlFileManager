<?php

namespace Devixar\SleepingowlFileManager\Helpers;

use Illuminate\Filesystem\Filesystem;

class PackHelper
{
    protected $laravelVersion = ['5.2'];

    protected $files;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function getValidLaravelVersion() {
        return $this->laravelVersion;
    }

    public function getValidLaravelVersionLine() {
        return implode(' ', $this->laravelVersion);
    }

    public function checkLaravelVersion($version)
    {
        $partsVersion = explode('.', $version);
        foreach ($this->laravelVersion as $ver)
        {
            $exploded_ver = explode('.', $ver);
            if($exploded_ver[0] == $partsVersion[0] && $exploded_ver[1] == $partsVersion[1])
            {
                return true;
            }
        }
        return false;
    }

    public function beatybool($boll)
    {
        return $boll ? 'success' : 'fail';
    }

    public function checkExistingPackage($vendor, $name, $path = 'vendor/')
    {
        return is_dir($path.$vendor.'/'.$name);
    }

    public function replaceAndSaveFile($oldFile, $search, $replace, $newFile = null)
    {
        return $this->replaceAndSaveFileList($oldFile, [$search => $replace], $newFile);
    }

    public function replaceAndSaveFileList($oldFile, array $listReplace, $newFile = null)
    {
        $newFile = ($newFile == null) ? $oldFile : $newFile;
        if(!$this->isFile($newFile))
        {
            $this->makeFile($newFile, '');
        }
        $file = $this->files->get($oldFile);

        $replacing = $file;
        foreach ($listReplace as $key => $value)
        {
            $replacing = str_replace($key, $value, $replacing);
        }

        $this->files->put($newFile, $replacing);
    }

    public function checkAddedServiceProvider($service, $pathConfig = '/config/app.php') {
        $pathConfig = getcwd() . $pathConfig;
        $configApp = $this->files->get($pathConfig);
        return strpos($configApp, $service) > -1;
    }

    public function isStringInFile($path, $string)
    {
        return strpos($this->getFileContent($path), $string) > -1;
    }

    public function getFileContent($path)
    {
        return $this->files->get($path);
    }

    public function makeDir($path)
    {
        if (!is_dir($path)) {
            return mkdir($path, 0777, true);
        }
    }

    public function makeFile($path, $content)
    {
        if (!is_file($path)) {
            return $this->files->put($path, $content);
        }
    }

    public function isFile($path)
    {
        return $this->files->isFile($path);
    }


}