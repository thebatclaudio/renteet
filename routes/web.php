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
        return redirect()->to("/home");
    }
    return view('welcome');
});

Route::get('/come-funziona', 'StaticPagesController@showHowItWorks');
Route::get('/come-funziona/locatori', 'StaticPagesController@showHowItWorksForLessors');
Route::get('/scopri-i-vantaggi', 'StaticPagesController@showAdvantages');
Route::get('/scopri-i-vantaggi/locatori', 'StaticPagesController@showAdvantagesForLessors');
Route::get('/termini-e-condizioni', 'StaticPagesController@showTermsAndConditions');
Route::get('/privacy-policy', 'StaticPagesController@showPrivacyPolicy');
Route::get('/cookie-policy', 'StaticPagesController@showCookiePolicy');
Route::get('/faq', 'StaticPagesController@showFAQ');
Route::get('/chi-siamo', 'StaticPagesController@showAbout');
Route::get('/i-nostri-valori', 'StaticPagesController@showOurValues');

Auth::routes();
Route::get('/facebook/redirect', 'Auth\SocialAuthController@redirect');
Route::get('/facebook/callback', 'Auth\SocialAuthController@callback');

// authenticated routes
Route::middleware(['auth'])->group(function (){
    Route::get('/home', 'HomeController@index')->name('home')->middleware('profile.complete');
    Route::get('/edit-profile', 'UserController@showEditProfileForm')->name("user.edit");
    Route::get('/profile/notifications', 'NotificationsController@index')->name('notifications');
    Route::get('/profile/requests/pending', 'UserController@pendingRequests')->name('pendingRequests');
    // step 1: carica foto
    Route::get('/complete-signup/upload-picture/', 'UploadPictureController@showUploadPictureForm');
    Route::post('/complete-signup/upload-picture/', 'UploadPictureController@uploadPicture')->name("upload-picture");
    // step 2: crop foto
    Route::get('/complete-signup/crop-picture/', 'UploadPictureController@showCropPicture');
    Route::post('/complete-signup/crop-picture/', 'UploadPictureController@cropPicture')->name("crop-picture");
    // step 3: dati personali
    Route::get('/complete-signup/personal-info/', 'UserController@showCompletePersonalInfoForm');
    Route::post('/complete-signup/personal-info/', 'UserController@completePersonalInfo')->name("complete-personal-info");
    // step 4: interessi
    Route::get('/complete-signup/interests', 'UserController@showInterestsForm');
    Route::post('/complete-signup/interests', 'UserController@saveInterests')->name("save-interests");
 
    Route::get('/profile/{id}', 'UserController@showProfile')->name('user.profile');
    Route::post('/room/{room}/user/{user}', 'RentController@allowUser')->name('allow.user');
    Route::prefix('ajax')->name('ajax.')->group(function () {
        Route::get('notifications', 'NotificationsController@ajaxIndex')->name('notifications');
        Route::post('/room/{id}/exit', 'RentController@exitFromHouse')->name('exit.room');
        Route::post('/room/{room}/user/{user}/setAvailableFrom', 'RentController@selectAvailableDate')->name('setAvailableFrom.room');
        Route::post('/room/{room}/user/{user}/remove', 'RentController@remove')->name('remove.room');
        Route::post('/room/{id}', 'RentController@rentHouse')->name('rent.room');
    });
 
    Route::get('/house', 'UserController@showHouse')->name('myHouse');
    Route::get('/house/{id}/thumbnail','HouseController@getThumbnail')->name('house.thumbnail');
    Route::post('/user/{id}/review','ReviewController@rateUser')->name('user.rate');
 
    //Not Used
    Route::post('/user/rating', 'ReviewController@rateUser')->name('user.rating');
    
    //admin routes, for who manage houses @remember: route name preceded always by "admin."
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', 'HomeController@dashboard')->name('dashboard');
        Route::prefix('house')->name('house.')->group(function () {
            Route::prefix('new/wizard')->name('wizard.')->group(function () {
                Route::get('first-step', 'AdminController@newHouseWizardStepOne')->name('one');
                Route::post('first-step', 'AdminController@newHouseWizardStepOneSave')->name('one.save');
                Route::get('second-step', 'AdminController@newHouseWizardStepTwo')->name('two');
                Route::post('second-step', 'AdminController@newHouseWizardStepTwoSave')->name('two.save');
                Route::get('third-step', 'AdminController@newHouseWizardStepThree')->name('three');
                Route::post('third-step-upload', 'AdminController@newHouseWizardStepThreeUpload')->name('three.upload');
                Route::post('third-step', 'AdminController@newHouseWizardStepThreeSave')->name('three.save');
                Route::get('last-step', 'AdminController@newHouseWizardStepFour')->name('four');
                Route::post('last-step', 'AdminController@newHouseWizardStepFourSave')->name('four.save');
            });
        });
        Route::get('house/{id}', 'AdminController@house')->name('house');
    });
    Route::get('/chat','ChatController@showChat')->name('chat.show');
    Route::get('/chat/{id}','ChatController@getMessages')->name('ajax.chat.messages');
    Route::post('/chat/{id}','ChatController@sendMessage')->name('ajax.chat.sendMessage');
    Route::post('/new-chat/{id}','ChatController@newChat')->name('chat.newChat');
});
Route::get('/rent/{id}', 'RentController@getHouse')->name('house');
Route::get('/search', 'SearchController@searchByCoordinates')->name('search.coordinates');