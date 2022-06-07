<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Site\HomeSiteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Site\PageSiteController;


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

Route::resource('/', HomeSiteController::class);

Route::prefix('painel')->group(function(){
    Route::get('/',             [HomeController::class, 'index'])->name('admin');
    
    Route::get('/login',        [LoginController::class, 'login'])->name('login');
    Route::post('/login',       [LoginController::class, 'autheticate'])->name('autheticate');
    
    Route::get('/register',     [RegisterController::class, 'index'])->name('register');
    Route::post('/register',    [RegisterController::class, 'register']);

    Route::post('logout',       [LoginController::class, 'logout'])->name('logout');

    Route::get('profile',       [ProfileController::class, 'index'])->name('profile');
    Route::put('profilesave',       [ProfileController::class, 'save'])->name('profile.save');

    Route::resource('users', UserController::class);

    Route::get('settings',           [SettingController::class, 'index'])->name('settings');
    Route::put('settingssave',       [SettingController::class, 'save'])->name('settings.save');

    Route::resource('pages',         PageController::class);

});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

Route::fallback([PageSiteController::class, 'index']);