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
    Route::get('/show_emi', 'EmiDetailsController@show')->name('emi_details.show');
    Route::post('process_emi', 'EmiDetailsController@processData')->name('emi_details.process');

    // user route
    Route::resource('users', 'UsersController');
    // Profile
    Route::get('/profile', 'AdminController@profile')->name('admin-profile');
    Route::post('/profile/{id}', 'AdminController@profileUpdate')->name('profile-update');
    // Password Change
    Route::get('change-password', 'AdminController@changePassword')->name('change.password.form');
    Route::post('change-password', 'AdminController@changPasswordStore')->name('change.password');
});
