<?php

    use Illuminate\Support\Facades\Route;

    $adminConfig = [
        'prefix'=>'manage',
        'namespace' => 'ManaCMS\ManaCategories\Http\Controllers\Admin',
        'as' => 'manage.',
        'middleware' => ['web','auth','admin'],
    ];

    Route::group($adminConfig,function () {
        Route::resource('category', 'CategoryController')->except('show');

        Route::group(['prefix'=>'batch','as'=>'batch.'],function(){
            Route::get('category', 'CategoryBatchController@create')->name('category.create');
            Route::patch('category', 'CategoryBatchController@store')->name('category.store');
            Route::get('category/export','CategoryBatchController@export')->name('category.export');
        });

    });
