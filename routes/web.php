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


Route::get('/', 'DocumentsController@index')->name('main');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/edit/{id}', 'HomeController@index');

Route::get('/get-documents', 'DocumentsController@getAll')->name('getDocuments');
Route::post('/copy-document', 'DocumentsController@copy')->name('copyDocument');
Route::delete('/delete-document', 'DocumentsController@delete')->name('deleteDocument');
Route::post('/get-document', 'DocumentsController@getById')->name('getById');
Route::post('/save-changes', 'DocumentsController@saveChanges')->name('saveChanges');
Route::post('/upload', 'DocumentsController@upload')->name('upload');

