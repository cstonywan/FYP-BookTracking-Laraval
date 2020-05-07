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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/b/search', 'BooksController@search')->name('searchBook');
Route::get('/b/detail/{id}', 'BooksController@detail')->name('bookDetail');
Route::get('/b/track/{id}', 'TrackingController@track')->name('trackBook');

Route::group(['middleware' => ['privacy']], function () {
    Route::get('/borrow/record/{id}', 'BorrowsController@record')->name('recordBorrow');
});

Route::group(['middleware' => ['manager']], function () {
    Route::post('/b/add', 'BooksController@store');
    Route::post('/b/edit/{id}', 'BooksController@edit');
    Route::get('/b/delete/{id}', 'BooksController@delete');
    Route::get('/b/manage', 'BooksController@manage')->name('manageBook');
    Route::get('/b/getajax', 'BooksController@getAjax');
   // Route::get('/b/postajax', 'BooksController@create');
    Route::post('/b/postajax', 'BooksController@postAjax');
});

Route::group(['middleware' => ['admin']], function () {
    Route::get('/user/manage', 'UsersController@manage')->name('manageUser');
    Route::post('/user/add', 'UsersController@store');
    Route::post('/user/edit/{id}', 'UsersController@edit');
    Route::get('/user/delete/{id}', 'UsersController@delete');
    Route::get('/rfid/rfidSetting','SetupController@showall')->name('manageRfid');
    Route::get('/rfid/rfidSetting/store','SetupController@store');    
    Route::get('/rfid/chart', 'chartController@Chart')->name('showChart');
    Route::get('/rfid/tracking/{id}', 'TrackingController@calculate');
   // Route::get('/rfid/getajax', 'chartController@getAjax');
    Route::post('/rfid/postajax', 'chartController@postAjax');
    // Route::get('/rfid/realtimechart', 'realtimeController@Chart')->name('showrealtimeChart');
     
    
});

Route::group(['middleware' => ['manager']], function () {
    Route::get('/borrow/manage', 'BorrowsController@manage')->name('manageBorrow');
    Route::post('/borrow/store', 'BorrowsController@store');
    Route::get('/borrow/return/{id}', 'BorrowsController@remand');
    Route::get('/borrow/renew/{id}', 'BorrowsController@renewal');
    Route::post('/borrow/edit/{id}', 'BorrowsController@edit');
    Route::get('/borrow/delete/{id}', 'BorrowsController@delete');
});

Route::get('/profile', 'UsersController@getProfile')->name('editProfile');
Route::post('/profile/edit', 'UsersController@editProfile');
 

//Route::get('/api/test','rfidReceive');
