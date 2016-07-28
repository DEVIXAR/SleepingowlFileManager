<?php

Route::group(['prefix' => 'sofmanager', 'middleware' => ['web']], function() {
    Route::get('getfile/{id}', 'Devixar\SleepingowlFileManager\Http\Controllers\FileController@getFileData');
});