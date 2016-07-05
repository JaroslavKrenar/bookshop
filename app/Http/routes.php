<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return "REST API By Jaroslav Krenar";
});

// API routes
Route::get('/api/v1/search', 'Api\V1\ApiController@search');
Route::post('/api/v1/add-book', 'Api\V1\ApiController@create');