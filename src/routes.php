<?php

    use Illuminate\Support\Facades\Route;

    Route::group([
        'prefix'=>'manage',
        'namespace' => 'Admin',
        'as' => 'manage.',
        'middleware' => ['auth','admin'],
    ],function () {
        Route::resource('category', 'CategoryController');
    });
