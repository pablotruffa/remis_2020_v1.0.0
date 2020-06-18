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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */


Route::post('login', 'Api\AuthController@login');

Route::middleware(['jwt.auth'])->group(function(){
    
    Route::get('/','Api\HomeController@index');
    Route::get('logout', 'Api\AuthController@logout');
    Route::get('about', 'Api\HomeController@about');
    Route::get('reservations','Api\ReservationController@all');
    
    Route::get('reservation/{id}','Api\ReservationController@byId');

    Route::get('reservations/confirmed','Api\ReservationController@confirmed');
    Route::get('reservations/initiated','Api\ReservationController@initiated');
    Route::get('reservations/postponed','Api\ReservationController@postponed');
    Route::get('reservations/cancelled','Api\ReservationController@cancelled');
    Route::get('reservations/completed','Api\ReservationController@completed');

    Route::post('reservation','Api\ReservationController@store');
    Route::put('reservation/{id}','Api\ReservationController@edit');

    //Reservations cannot be deleted but they can be cancelled
    Route::delete('reservation/{id}','Api\ReservationController@cancel');
    
});
    
    





