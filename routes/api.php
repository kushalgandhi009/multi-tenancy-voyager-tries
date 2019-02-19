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

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::group([
        'as'     => 'settings.',
        'prefix' => 'settings',
    ], function ()  {
        Route::get('/', ['uses' => 'API\SettingsController@index','as' => 'index']);
    });
   
    Route::post('login', 'API\UserController@login');
    
    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('details', 'API\UserController@details');
        Route::post('logout', 'API\UserController@logout');
        
        Route::group(['prefix' =>'dataset'], function(){
            Route::post('init', 'API\DatasetController@init');
            Route::get('status/{datasetId}', 'API\DatasetController@status');
            Route::post('addNotificationEmail', 'API\DatasetController@addNotificationEmail');
        });
    });
});
