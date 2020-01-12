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

Route::get('/', 'HomeController@index')->name('home');


/* KONTO */
Auth::routes(['verify' => true]);
Route::post('verification_email', function (){
    if(\Illuminate\Support\Facades\Auth::check()){
        \Illuminate\Support\Facades\Auth::user()->sendEmailVerificationNotification();
    }
    return back();
})->name('send_verification_link');
Route::get('konto/{id}/{tab?}', 'UserController@show')->name('account.index');
/* KONTO */


/* POSTY */
Route::resource('/posts', 'PostController');
Route::get('/tags', 'HomeController@getTags');
Route::group(['middleware' => 'auth'], function(){
    Route::post('/user/{id}/update', 'UserController@update')->name('account.update');
});
/* POSTY */


/* KOMENTARZE */
Route::resource('comments', 'CommentController');
/* KOMENTARZE */


/* OCENY */
Route::resource('rates', 'RateController');
/* OCENY */


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('categories/relation', 'Voyager\CategoryController@getRelationCategories')->name('voyager.categories.relation');
});

Route::resource('categories', 'CategoryController');
Route::get('/kategoria/{slug}/{slug_2?}', 'CategoryController@show')->name('categories.show');
Route::post('upload/{path}', 'UploadController@upload');