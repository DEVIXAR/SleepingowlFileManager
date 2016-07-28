<?php

namespace Devixar\SleepingowlFileManager\Http\Controllers;

use Illuminate\Routing\Controller;

class FileController extends Controller
{
    public function getFileData($id)
    {
        return response()->json(\Jasekz\Laradrop\Models\File::find($id));
    }
}