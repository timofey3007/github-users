<?php

Route::get('seed', 'App\Http\Controllers\GitUserController@seed');

Route::prefix('api')->group(function () {
    Route::resource('git_users', 'App\Http\Controllers\GitUserController');
});