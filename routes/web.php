<?php

use Illuminate\Routing\RouteGroup;
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
    return redirect(route('login'));
});
Route::get('phpinfo', function () {
    phpinfo();
});

Route::middleware(['role'])->group(function () {
    // dashboard
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('dashboard/chart', 'DashboardController@chart')->name('dashboard.chart');
    // customer
    Route::get('customer', 'CustomerController@index')->name('customer');
    Route::get('customer/riwayat/{id}', 'CustomerController@riwayat')->name('customer.riwayat');
    // katalog
    Route::get('e-katalog', 'KatalogController@index')->name('katalog');
    Route::post('katalog/upload', 'KatalogController@upload')->name('upload.katalog');
    // services
    Route::get('booking', 'ServiceController@index')->name('booking');
    Route::get('upcoming', 'ServiceController@upcoming')->name('upcoming');
    // grafik
    Route::get('grafik/label_service', 'GrafikController@label_service')->name('grafik.label_service');
    Route::get('grafik/jumlah_service', 'GrafikController@jumlah_service')->name('grafik.jumlah_service');
    Route::get('chart_label', 'GrafikController@chart_label')->name('chart_label');
    Route::get('chart_jumlah_service', 'GrafikController@chart_jumlah_service')->name('chart_jumlah_service');
});

// crud firebase
Route::get('create', 'FirebaseController@set');
Route::get('read', 'FirebaseController@read');
Route::get('update', 'FirebaseController@update');
Route::get('delete', 'FirebaseController@delete');


Route::get('login', 'LoginController@getLogin')->name('login');
Route::get('register', 'LoginController@signUp')->name('register');
Route::post('login', 'LoginController@postLogin');
Route::get('logout', 'LoginController@logout')->name('logout');
