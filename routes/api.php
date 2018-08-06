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
    Route::get('getcorpus','ElasticController@getCorpus');
    Route::get('getdocument','ElasticController@getDocument');
    Route::get('getannotation','ElasticController@getAnnotation');
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
    Route::post('userrolesbycorpus','CorpusController@storeRelationsByCorpus');
    Route::post('deleterolesbycorpus','CorpusController@deleteRelationsByCorpus');
    Route::post('deleterolesbyproject','CorpusProjectController@deleteRelationsByProject');
    Route::post('deletemultiple','GitRepoController@deleteMultipleFiles');
    Route::post('createFormat','GitRepoController@createFormatFolder');
    Route::post('validateHeaders','GitRepoController@validateCorpus');
    Route::post('preparePublication','CorpusController@preparePublication');
    Route::post('updateCorpusProject/{corpusProject}','CorpusProjectController@update');
    Route::post('postMessage','MessageBoardController@create');
    Route::post('assignMessage','MessageController@assignMessage');
    Route::post('completeMessage','MessageController@completeMessage');
    Route::post('deleteMessage','MessageController@destroyMessage');

});

Route::group(array('prefix' => 'browseapi'), function() {
    Route::post('scrapeLicenseDeed','ScraperController@scrapeLicenseDeed');
});



Route::group(array('prefix' => 'dashboardapi'), function() {
    Route::get('user_assignments','DashboardController@userAssignments');
});


