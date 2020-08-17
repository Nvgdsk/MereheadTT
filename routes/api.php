<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('registration', 'AuthController@registration');

});
Route::group([
    'prefix' => 'liblary'
], function () {
    Route::get('/authors', 'LiblaryController@getAuhtors');
    Route::get('/books', 'LiblaryController@getBooks');
    Route::get('/author/{id}/books', 'LiblaryController@getBooksAuthor');

});
Route::group([
    'prefix' => 'liblary',

    'middleware' => 'auth'
], function () {
    Route::post('/userBooks', 'LiblaryController@userBooks');
    Route::post('/createBook', 'LiblaryController@create');
    Route::post('/editBook', 'LiblaryController@edit');
    Route::post('/removeBook/{id}', 'LiblaryController@remove');
});