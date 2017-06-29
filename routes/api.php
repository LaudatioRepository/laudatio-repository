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



Route::get('sample-restful-apis', function()
{
    return array(
        1 => "expertphp",
        2 => "demo"
    );
});

Route::group(array('prefix' => 'searchapi'), function() {
    Route::get('search/{index}/{field}/{searchterm}','ElasticController@search');
    Route::post('searchGeneral','ElasticController@searchGeneral');
});


