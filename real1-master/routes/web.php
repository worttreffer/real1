<?php

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

// Security
Auth::routes(['verify' => true]);

// Overview related


// Basic Profil relatad
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home/saveProfile', 'HomeController@saveAddress');

// Event Profil related
Route::get('/home/event/{id}', 'EventController@index');
Route::get('/home/event/{id}/edit', 'EventController@edit');
Route::post('/home/event/{id}/save', 'EventController@save');
Route::post('/home/event/{id}/delete', 'EventController@delete');

// Artist Profil related
Route::get('/home/artist/{id}', 'ArtistController@index');
Route::get('/home/artist/{id}/edit', 'ArtistController@edit');
Route::post('/home/event/{id}/save', 'ArtistController@save');
Route::post('/home/artist/{id}/delete', 'ArtistController@delete');

// Location Profil related
Route::get('/home/location/{id}', 'LocationController@index');
Route::get('/home/location/{id}/edit', 'LocationController@edit');
Route::post('/home/location/{id}/save', 'LocationController@save');
Route::post('/home/location/{id}/delete', 'LocationController@delete');

// Static Pages
Route::get('/impressum', function () {
    return view('static/imprint');
})->name('imprint');
