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



Route::group(array('prefix' => 'searchapi'), function() {
    Route::get('search/{index}/{field}/{searchterm}','ElasticController@search');
    Route::post('searchGeneral','ElasticController@searchGeneral');
    Route::post('searchCorpus','ElasticController@searchCorpusIndex');
    Route::post('searchDateRange','ElasticController@searchCorpusIndex');
    Route::post('searchDocument','ElasticController@searchDocumentIndex');
    Route::post('searchDocumentWithParam','ElasticController@searchDocumentIndexWithParam');
    Route::post('getSearchTotal','ElasticController@getSearchTotal');
    Route::post('searchAnnotation','ElasticController@searchAnnotationIndex');
    Route::post('getCorpusTitlesByDocument','ElasticController@getCorpusTitlesByDocument');
    Route::post('getCorpusByDocument','ElasticController@getCorpusByDocument');
    Route::post('getDocumentsByCorpus','ElasticController@getDocumentsByCorpus');
    Route::post('getAnnotationsByCorpus','ElasticController@getAnnotationByCorpus');
    Route::post('getDocumentsByAnnotation','ElasticController@getDocumentsByAnnotation');
    Route::post('getCorporaByAnnotation','ElasticController@getCorporaByAnnotation');

    Route::post('getAnnotationsByDocument','ElasticController@getAnnotationsByDocument');

    Route::post('truncateIndex','ElasticController@truncateIndex');
});

Route::group(array('prefix' => 'adminapi'), function() {
    Route::post('userroles','RoleController@storeRelations');
    Route::post('userrolesbyproject','CorpusProjectController@storeRelationsByProject');
    Route::post('userrolesbycorpus','CorpusController@storeRelationsByProject');
    Route::post('deletemultiple','GitRepoController@deleteMultipleFiles');
});


