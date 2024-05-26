<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use App\Http\Controllers\EmiDetailsController;
use App\Http\Controllers\LoanDetailsController;

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

// CACHE CLEAR ROUTE
Route::get('cache-clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    session()->flash('success', 'Successfully cache cleared.');
    return redirect()->back();
})->name('cache.clear');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/admin'); // Redirect to dashboard if user is authenticated
    }
    return view('auth.login'); // Otherwise, show the login view
});

Route::post('/login', 'AdminController@login')->name('login');
// Backend section start
Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'admin']], function () {

    Route::get('/', 'AdminController@index')->name('admin');
    Route::post('/logout', 'AdminController@logout')->name('logout');
    Route::get('/loan_details', 'LoanDetailsController@index')->name('loan_details');
    Route::get('/emi_details', 'EmiDetailsController@index')->name('emi_details');
    // user route
    Route::resource('users', 'UsersController');
    // Banner
    Route::resource('banner', 'BannerController');

    // Profile
    Route::get('/profile', 'AdminController@profile')->name('admin-profile');
    Route::post('/profile/{id}', 'AdminController@profileUpdate')->name('profile-update');
    // Password Change
    Route::get('change-password', 'AdminController@changePassword')->name('change.password.form');
    Route::post('change-password', 'AdminController@changPasswordStore')->name('change.password');
});

// STORAGE LINKED ROUTE
Route::get('storage-link', [\App\Http\Controllers\AdminController::class, 'storageLink'])->name('storage.link');

Route::post('process_emi', [EmiDetailsController::class, 'processData'])->name('emi_details.process');
Route::get('show_emi', [EmiDetailsController::class, 'show'])->name('emi_details.show');
