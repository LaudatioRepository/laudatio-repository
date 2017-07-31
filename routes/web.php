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

Route::get('/', ['uses' => 'IndexController@index']);

Auth::routes();

Route::get('/admin', ['uses' => 'IndexController@admin'])->middleware('auth');

Route::get('/admin/corpusprojects',[ 'as' => 'admin.corpusProject.index', 'uses' => 'CorpusProjectController@index'])->middleware('auth');
Route::get('/admin/corpusprojects/create',[ 'as' => 'admin.corpusProject.create.', 'uses' => 'CorpusProjectController@create'])->middleware('auth');
Route::post('/admin/corpusprojects',[ 'as' => 'admin.corpusProject.store.', 'uses' => 'CorpusProjectController@store'])->middleware('auth');

Route::get('/search',['as' => 'search', 'uses' => 'SearchController@index']);

Route::get('/repository',[ 'as' => 'gitLab', 'uses' => 'GitLabController@listProjects'])->middleware('auth');


Route::get('/schema/{path?}',[ 'as' => 'gitRepo.route.schema', 'uses' => 'GitRepoController@listSchema'])->where('path', '.+')->middleware('auth');


Route::get('/viewFile/{path}',[ 'as' => 'gitRepo.readFile.route', 'uses' => 'GitRepoController@readFile'])->where('path', '.+')->middleware('auth');
Route::get('/deleteFile/{path}',[ 'as' => 'gitRepo.deleteFile.route', 'uses' => 'GitRepoController@deleteFile'])->where('path', '.+')->middleware('auth');
Route::get('/updateFile/{path}',[ 'as' => 'gitRepo.updateFile.route', 'uses' => 'GitRepoController@updateFileVersion'])->where('path', '.+')->middleware('auth');

Route::get('/addFiles/{path}',[ 'as' => 'gitRepo.addFile.route', 'uses' => 'GitRepoController@addFiles'])->where('path', '.+')->middleware('auth');
Route::get('/commitFiles/{dirname}/{commitmessage}',[ 'as' => 'gitRepo.commitFiles.route', 'uses' => 'GitRepoController@commitFiles'])->where('dirname', '.+')->middleware('auth');

Route::get('/commitMessage/{dirname}',[ 'as' => 'gitRepo.commit.route', 'uses' => 'CommitController@commitForm'])->where('dirname', '.+')->middleware('auth');

Route::post('/commit',['as' => 'gitRepo.commit.post', 'uses' => 'CommitController@commitSubmit'])->middleware('auth');

Route::get('/upload/{dirname?}',['as' => 'gitRepo.upload.get', 'uses' => 'UploadController@uploadForm'])->where('dirname', '.+')->middleware('auth');
Route::post('/upload',['as' => 'gitRepo.upload.post', 'uses' => 'UploadController@uploadSubmit'])->middleware('auth');






/**OLD**/
Route::get('/createproject/{dirname?}',['as' => 'gitRepo.createproject.get', 'uses' => 'GitRepoController@createProjectForm'])->where('dirname', '.+')->middleware('auth');
Route::post('/createproject',['as' => 'gitRepo.createproject.post', 'uses' => 'GitRepoController@createProjectSubmit'])->middleware('auth');
Route::get('/projects/{path?}',[ 'as' => 'gitRepo.route', 'uses' => 'GitRepoController@listProjects'])->where('path', '.+')->middleware('auth');
/** END OLD **/

Route::get('/createcorpus/{dirname?}',['as' => 'gitRepo.createcorpus.get', 'uses' => 'GitRepoController@createCorpusForm'])->where('dirname', '.+')->middleware('auth');
Route::post('/createcorpus',['as' => 'gitRepo.createcorpus.post', 'uses' => 'GitRepoController@createCorpusSubmit'])->middleware('auth');


Route::get('/validatetei/{dirname}',['as' => 'gitRepo.validatetei.get', 'uses' => 'ValidateTEIController@validateFiles'])->where('dirname', '.+')->middleware('auth');


Route::get('/browse/{header}/{id}', ['as' => 'browse.showHeaders.get', 'uses' => 'BrowseController@index']);
