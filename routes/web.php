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

//Index Page
Route::get('/', function() {
    return view('index');
});


//Private Solo Page
Route::get('/room_list', function() {
    return view('room_list');
});

//Privacy Policy Page
Route::get('/privacy_policy', function() {
    return view('privacy_policy');
});


//404 Error page
Route::get('/404', function() {
    return view('errors.404');
});