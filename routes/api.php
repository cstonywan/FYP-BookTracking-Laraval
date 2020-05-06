<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/api/test','apiController@test');

Route::post('/rfidData','apiController@store');
// Route::post('/rfidget','rfidClientReceive@handle_connect');
Route::post('/b/list', 'API\BooksController@list');
Route::get('b/detail/{id}', 'API\BooksController@detail');
Route::get('user/{id}', 'API\AuthController@getUser');
Route::get('/record/{id}', 'API\BooksController@record');
Route::post('/login', 'API\AuthController@login');
Route::post('/signup', 'API\AuthController@signup');

Route::post('/edit/name', 'API\AuthController@editName');
Route::post('/edit/email', 'API\AuthController@editEmail');
Route::post('/upload/photo', 'API\AuthController@uploadPhoto');
Route::get('/b/track/{id}', 'API\BooksController@track');


