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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes(['register'=>false]);

Route::get('/', 'HomeController@index')->name('home');

Route::get('nas',                                           'NASController@index')->name('nas.index');
Route::post('/nas/search',                                  'NASController@indexSearch')->name('nas.search');
Route::get('/nas/create',                                   'NASController@create')->name('nas.create');
Route::post('nas',                                          'NASController@store')->name('nas.store');
Route::get('nas/{nas}',                                     'NASController@show')->name('nas.show');
Route::get('nas/{nas}/edit',                                'NASController@edit')->name('nas.edit');
Route::put('nas/{nas}',                                     'NASController@update')->name('nas.update');
Route::delete('nas/{nas}',                                  'NASController@destroy')->name('nas.destroy');

Route::get('test','MikrotikController@fetch');

