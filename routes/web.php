<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    // Admin Login Route
    Route::match(['get', 'post'], 'login', 'AdminController@login');

    Route::group(['middleware' => ['admin']], function () {
        // Admin Dashboard Route
        Route::get('dashboard', 'AdminController@dashboard');

        // Check Current Password
        Route::post('check-current-password', 'AdminController@checkCurrentPassword');


        // Update Admin Password
        Route::match(['get', 'post'], 'update-admin-password', 'AdminController@updateAdminPassword');

        // Update Admin Details
        Route::match(['get', 'post'], 'update-admin-details', 'AdminController@updateAdminDetails');

        // Update Vendor Details
        Route::match(['get', 'post'], 'update-vendor-details/{slug}', 'AdminController@updateVendorDetails');

        // View Admins / Sub Admins / Vendors
        Route::get('admins/{type?}', 'AdminController@admins');

        // View Admins / Sub Admins / Vendors
        Route::get('admins/{type?}', 'AdminController@admins');

        // View Vendors Details
        Route::get('view-vendor-details/{id}', 'AdminController@viewVendorDetails');

        // Update Admin Status
        Route::post('update-admin-status', 'AdminController@updateAdminStatus');


        // Admin Logout
        Route::get('logout', 'AdminController@logout');


        // Sections
        Route::get('sections', 'SectionController@sections');
        // Update Section Status
        Route::post('update-section-status', 'SectionController@updateSectionStatus');
        // Delete Sections
        Route::get('delete-section/{id}', 'SectionController@deleteSection');

        // Add and Delete sections
        //Route::match(['get', 'post'], 'add-edit-section/{id}', 'SectionController@addEditSection');
        Route::match(['get', 'post'], 'add-edit-section/{id?}', 'SectionController@addEditSection');
        //Route::match(['get', 'post'], 'add-edit-section/{id}', 'SectionController@addEditSection');
        Route::match(['get', 'post'], 'add-section/', 'SectionController@addSection');
    });
});
