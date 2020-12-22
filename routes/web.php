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
    return view('login');
})->name('login');


Route::get('/callback', 'GitHubReportsController@login')->name('report.login');
Route::get('/dashboard', 'GitHubReportsController@dashboard')->name('report.show');
Route::get('/run-report', 'GitHubReportsController@runReport')->name('report.run');
Route::get('/report-detail/{id}', 'GitHubReportsController@detail')->name('report.detail');