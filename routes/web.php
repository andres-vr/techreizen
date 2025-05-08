<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuestRegistrationController;
use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'show'])->name('home');
Route::resource('page', PageController::class);

//route for AJAX request
Route::get('/majors/{educationId}', [GuestRegistrationController::class, 'getMajorsByEducation'])->name('majors.byEducation');

Auth::routes();

/*------------------------------------------
--------------------------------------------
All guest Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:guest'])->group(function () {
    // Disclaimer page - make sure both GET and POST routes are defined
    Route::get('/disclaimerPage', [HomeController::class, 'disclaimerPage'])->name('guest.disclaimer');
    Route::post('/disclaimerPage', [HomeController::class, 'acceptDisclaimer'])->name('guest.disclaimer.accept');

    // Guest Registration Routes 
    Route::prefix('registration')->group(function () {
        // Step 1: Basic Info
        Route::get('/basic-info', [GuestRegistrationController::class, 'showBasicInfoForm'])
            ->name('guest.registration.basic-info');
        Route::post('/basic-info', [GuestRegistrationController::class, 'submitBasicInfo'])
            ->name('guest.registration.basic-info.submit');

        // Step 2: Personal Info
        Route::get('/personal-info', [GuestRegistrationController::class, 'showPersonalInfoForm'])
            ->name('guest.registration.personal-info');
        Route::post('/personal-info', [GuestRegistrationController::class, 'submitPersonalInfo'])
            ->name('guest.registration.personal-info.submit');

        // Step 3: Contact Info and Account Creation
        Route::get('/contact-info', [GuestRegistrationController::class, 'showContactInfoForm'])
            ->name('guest.registration.contact-info');
        Route::post('/contact-info', [GuestRegistrationController::class, 'submitContactInfo'])
            ->name('guest.registration.contact-info.submit');
            
        // Step 4: Confirmation page
        Route::get('/confirmation', [GuestRegistrationController::class, 'showConfirmationPage'])
            ->name('guest.registration.confirmation');
        Route::post('/confirmation', [GuestRegistrationController::class, 'submitConfirmation'])
            ->name('guest.registration.confirmation.submit');
    });

    Route::get('/register', function () {
        return redirect()->route('guest.disclaimer');
    })->name('register');
});

/*------------------------------------------
--------------------------------------------
All traveller Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:traveller'])->group(function () {

    Route::get('/traveller/home', [HomeController::class, 'travellerHome'])->name('traveller.home');
});

/*------------------------------------------
--------------------------------------------
All Guide Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:guide'])->group(function () {

    Route::get('/guide/home', [HomeController::class, 'guideHome'])->name('guide.home');
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
});

Route::get('/home', [PageController::class, 'show'])->name('home');

Route::get('/voorbeeldreizen', [PageController::class, 'show'])->name('voorbeeldreizen');

Route::get('/editor', [PageController::class, 'show'])->name('editor');

Route::get('/pages/{id}', [PageController::class, 'getPage']);


Route::get('/{routename}', [PageController::class, 'showByName'])->name('dynamic.page');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::post('/editor', [PageController::class, 'saveEditorContent'])->name('editor.save');


Route