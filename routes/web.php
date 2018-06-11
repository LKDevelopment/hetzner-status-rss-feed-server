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

Route::get('/', function () {
    if (request()->getBaseUrl() == 'hetzner-status.lkdev.co') {
        return view('welcome');
    } else {
        if (auth()->check()) {
            return redirect()->to('/home');
        }

        return redirect()->to('/login');
    }
});
Route::get('cloud', 'Web\CloudHostController@form');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('messages', 'Web\Messages');
Route::get('messages/{message}/delete', 'Web\Messages@destroy')->name('messages.delete');
Route::resource('devices', 'Web\DeviceController');
Route::resource('feature_flags', 'Web\FeatureFlagController');
Route::get('feature_flags/{feature_flag}/delete', 'Web\FeatureFlagController@destroy')->name('feature_flags.delete');
Route::group(['prefix' => 'devices/{device}'], function () {
    Route::get('feature_flags', 'Web\DeviceController@feature_flags')->name('devices.feature_flags');
    Route::put('feature_flags', 'Web\DeviceController@save_feature_flags');
});
Route::group(['prefix' => 'statics'], function () {
    Route::get('dashboard', 'Web\StaticsController@dashboard')->name('statics.dashboard');
    Route::get('tracing_cache', 'Web\StaticsController@getTracingCache')->name('statics.tracing_cache');
});