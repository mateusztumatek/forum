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
    return view('home');
});

Auth::routes(['verify' => true]);
Route::post('verification_email', function (){
    if(\Illuminate\Support\Facades\Auth::check()){
        \Illuminate\Support\Facades\Auth::user()->sendEmailVerificationNotification();
    }
    return back();
})->name('send_verification_link');
Route::get('konto/{id}/{tab?}', 'UserController@show')->name('account.index');
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function(){
    Route::post('/user/{id}/update', 'UserController@update')->name('account.update');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
