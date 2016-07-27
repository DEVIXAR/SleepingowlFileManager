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


}