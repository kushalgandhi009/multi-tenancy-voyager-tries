<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'v1',
], function ()  {

    // Route::middleware('auth:api')->get('/user', function (Request $request) {
    //     return $request->user();
    // });
    
    Route::group([
        'as'     => 'settings.',
        'prefix' => 'settings',
    ], function ()  {
        Route::get('/', ['uses' => 'API\SettingsController@index','as' => 'index']);
    });

    Route::group(['middleware' => 'guest'], function(){
        Route::post('login', 'API\UserController@login');
        Route::post('signup', 'API\UserController@register');
    });
    
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('user', 'API\UserController@details');
        Route::post('logout', 'API\UserController@logout');
        
        Route::group(['prefix' =>'dataset'], function(){
            Route::post('init', 'API\DatasetController@init');
            Route::get('status/{datasetId}', 'API\DatasetController@status');
            Route::post('addNotificationEmail', 'API\DatasetController@addNotificationEmail');
        });
    });
});
