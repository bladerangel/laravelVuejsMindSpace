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

Route::post('/quote', 'QuoteController@postQuote')->middleware('jwt.auth');
Route::get('/quotes', 'QuoteController@getQuotes')->middleware('jwt.auth');
Route::put('/quote/{id}', 'QuoteController@putQuote')->middleware('jwt.auth');
Route::delete('/quote/{id}', 'QuoteController@deleteQuote')->middleware('jwt.auth');
Route::post('/user', 'UserController@signup');
Route::post('/user/signin', 'UserController@signin');
