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

$api = app('Dingo\Api\Routing\Router');

$api->version('v0.1.0', function ($api) {

    $api->group(['middleware' => 'bindings'], function($api){

        $api->get('users/{user}/transactions', 'App\Http\Controllers\UserController@api_fetchTransactionData');

    });

});