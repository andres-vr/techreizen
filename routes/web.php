<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuestRegistrationController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();
/*------------------------------------------
--------------------------------------------
All guest Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:guest'])->group(function () {
    // Disclaimer page
    Route::get('/disclaimerPage', [HomeController::class, 'disclaimerPage'])->name('guest.disclaimer');

    //TODO: This function has not been implemented yet in the controller class !!!
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
            
        // TODO: Step 3: Medical Info and Account Creation
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
