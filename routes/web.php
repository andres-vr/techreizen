<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'show'])->name('home');
Route::resource('page', PageController::class);

Auth::routes();
/*------------------------------------------
--------------------------------------------
All guest Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:guest'])->group(function () {

    //Route::get('/home', [HomeController::class, 'index'])->name('home');
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

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
