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
    if(\Auth::check()) {
        return redirect()->to("/rent/1");
    }
    return view('welcome');
});

Auth::routes();

// authenticated routes
Route::middleware(['auth'])->group(function (){
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/edit-profile', 'UserController@showEditProfileForm')->name("user.edit");
    Route::get('/complete-signup/upload-picture/', 'UploadPictureController@showUploadPictureForm');
    Route::post('/complete-signup/upload-picture/', 'UploadPictureController@uploadPicture')->name("upload-picture");
    Route::get('/complete-signup/crop-picture/', 'UploadPictureController@showCropPicture');
    Route::post('/complete-signup/crop-picture/', 'UploadPictureController@cropPicture')->name("crop-picture");
    Route::post('/room/{id}', 'RentController@rentHouse')->name('rent.room');
    Route::get('/profile/{id}', 'UserController@showProfile')->name('user.profile');

    Route::post('/room/{room}/user/{user}', 'RentController@allowUser')->name('allow.user');

    // admin routes, for who manage houses
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', 'HomeController@dashboard')->name('dashboard');
        Route::get('house/{id}', 'AdminController@house')->name('house');
    });
});

Route::get('/rent/{id}', 'RentController@getHouse');
Route::get('/search', 'SearchController@searchByCoordinates')->name('search.coordinates');
