<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    $env = app(\Hyn\Tenancy\Environment::class);
    $fqdn = optional($env->hostname())->fqdn;

    $systemSite = \App\Tenant::getRootFqdn();

    if ( $fqdn === $systemSite ) {
        return redirect('/admin');
    }

    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') { 
        //
        $protocol = 'https://';
    } else {
        $protocol = 'http://';
    }

    $fqdn = $protocol . preg_replace('/(.*)(\.' . $systemSite . '$)/', '$1', $fqdn);

    return redirect($fqdn);
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/storage/{path}', '\App\Http\Controllers\HynOverrideMediaController')
    ->where('path', '.+')
    ->name('tenant.media');
