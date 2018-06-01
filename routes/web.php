<?php


Auth::routes();
Route::post('login', ['as' => 'login', 'uses' => 'Auth\LoginController@doLogin']);
Route::get('signin', ['as' => 'signin', 'uses' => 'Auth\LoginController@signin']);


Route::get('/', ['as' => 'frontpage', 'uses' => 'IndexController@index']);
Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index'])->middleware('auth');
Route::get('/admin', ['as' => 'admin', 'uses' => 'AdminController@index']);
Route::get('/browse', ['as' => 'browse', 'uses' => 'BrowseController@index']);
Route::get('/publish', ['as' => 'publish', 'uses' => 'IndexController@publish']);
Route::get('/schema/{path?}',[ 'as' => 'gitRepo.route.schema', 'uses' => 'GitRepoController@listSchema'])->where('path', '.+')->middleware('auth');
Route::get('/search',['as' => 'search', 'uses' => 'SearchController@index']);



/** CORPUS PROJECTS  **/
Route::get('/corpusprojects',[ 'as' => 'corpusProject.index', 'uses' => 'CorpusProjectController@index'])->middleware('auth');
Route::get('/corpusprojects/create',[ 'as' => 'corpusProject.create', 'uses' => 'CorpusProjectController@create'])->middleware('auth');
Route::get('/corpusprojects/{corpusproject}',[ 'as' => 'corpusProject.show', 'uses' => 'CorpusProjectController@show'])->middleware('auth');
Route::post('/corpusprojects/createproject',[ 'as' => 'corpusProject.store.', 'uses' => 'CorpusProjectController@store'])->middleware('auth');
Route::get('/corpusprojects/{corpusproject}/edit',[ 'as' => 'corpusProject.edit', 'uses' => 'CorpusProjectController@edit'])->middleware('auth');
Route::get('/corpusprojects/{corpusproject}/delete',[ 'as' => 'corpusProject.delete', 'uses' => 'CorpusProjectController@delete'])->middleware('auth');
Route::get('/corpusprojects/{corpusproject}/{user}/delete',[ 'as' => 'project.usercorpusroles.destroy', 'uses' => 'CorpusProjectController@destroyCorpusProjectUser'])->middleware('auth');
Route::patch('/corpusprojects/{corpusproject}',[ 'as' => 'corpusProject.update', 'uses' => 'CorpusProjectController@update'])->middleware('auth');
Route::delete('/corpusprojects/{corpusproject}',[ 'as' => 'corpusProject.destroy', 'uses' => 'CorpusProjectController@destroy'])->middleware('auth');

Route::get('/corpusprojects/assigncorpora/{corpusproject}',[ 'as' => 'corpusProject.assignCorpora', 'uses' => 'CorpusProjectController@assignCorpora'])->middleware('auth');
Route::post('/corpusprojects/{corpusproject}/corpora',[ 'as' => 'corpusProject.assign.store.', 'uses' => 'CorpusProjectController@storeCorpusRelations'])->middleware('auth');
Route::get('/corpusprojects/inviteusers',[ 'as' => 'corpusProject.invitations', 'uses' => 'CorpusProjectController@inviteUsers'])->middleware('auth');
Route::get('/corpusprojects/assignusers/{corpusproject}',[ 'as' => 'corpusProject.assignusers', 'uses' => 'CorpusProjectController@assignUsers'])->middleware('auth');
Route::post('/corpusprojects/{corpusproject}/users',[ 'as' => 'corpusProject.StoreUsers', 'uses' => 'CorpusProjectController@storeUserRelations'])->middleware('auth');
/** END CORPUS PROJECTS  **/

/** HEADERS  **/
Route::get('/corpusprojects/corpora',[ 'as' => 'corpus.index', 'uses' => 'CorpusController@index'])->middleware('auth');
Route::get('/corpusprojects/corpora/create/{corpusproject}',[ 'as' => 'corpus.create', 'uses' => 'CorpusController@create'])->middleware('auth');
Route::get('/corpusprojects/corpora/{corpus}/edit/',[ 'as' => 'corpus.edit', 'uses' => 'CorpusController@edit'])->middleware('auth');
Route::get('/corpusprojects/corpora/{corpus}/delete/{corpusproject_directory_path}',[ 'as' => 'corpus.delete', 'uses' => 'CorpusController@delete'])->middleware('auth');
Route::get('/corpusprojects/corpora/assignusers/{corpus}',[ 'as' => 'corpus.assignusers', 'uses' => 'CorpusController@assignCorpusUsers'])->middleware('auth');;
Route::get('/corpusprojects/corpora/{corpus}/{filepath}/show',[ 'as' => 'corpus.filepath.show', 'uses' => 'CorpusController@showFilePath'])->where('filepath', '.+')->middleware('auth');
Route::get('/corpusprojects/corpora/{corpus}/{path?}',[ 'as' => 'corpus.show', 'uses' => 'CorpusController@show'])->where('path', '.+')->middleware('auth');
Route::post('/corpusprojects/corpora',[ 'as' => 'corpus.store', 'uses' => 'CorpusController@store'])->middleware('auth');
Route::get('/corpusprojects/corpora/{corpus}/{user}/delete',[ 'as' => 'project.usercorpusroles.destroy', 'uses' => 'CorpusController@destroyCorpusUser'])->middleware('auth');
Route::delete('/corpusprojects/corpora/{corpus}/{projectId}',[ 'as' => 'corpus.destroy', 'uses' => 'CorpusController@destroy'])->middleware('auth');
/** END CORPORA  **/



/** UPLOAD **/
Route::get('/corpusprojects/upload/{dirname?}',['as' => 'gitRepo.upload.get', 'uses' => 'UploadController@uploadForm'])->where('dirname', '.+')->middleware('auth');
Route::get('/corpusprojects/uploadFiles/{dirname?}',['as' => 'gitRepo.uploadFiles.get', 'uses' => 'UploadController@uploadDataForm'])->where('dirname', '.+')->middleware('auth');
Route::post('/corpusprojects/upload',['as' => 'gitRepo.upload.post', 'uses' => 'UploadController@uploadSubmit'])->middleware('auth');
Route::post('/corpusprojects/uploadFiles',['as' => 'gitRepo.uploadFiles.post', 'uses' => 'UploadController@uploadSubmitFiles'])->middleware('auth');
/** END UPLOAD **/


/** ROLES  **/

Route::get('/admin/roles',[ 'as' => 'admin.roles.index', 'uses' => 'RoleController@index'])->middleware('auth');
Route::get('/admin/roles/create',[ 'as' => 'admin.roles.create', 'uses' => 'RoleController@create'])->middleware('auth');
Route::post('/admin/roles',[ 'as' => 'admin.roles.store', 'uses' => 'RoleController@store'])->middleware('auth');
Route::get('/admin/roles/{role}',[ 'as' => 'admin.roles.show', 'uses' => 'RoleController@show'])->middleware('auth');
Route::get('/admin/roles/{role}/edit',[ 'as' => 'admin.roles.edit', 'uses' => 'RoleController@edit'])->middleware('auth');
Route::get('/admin/roles/{role}/delete',[ 'as' => 'admin.roles.delete', 'uses' => 'RoleController@delete'])->middleware('auth');
Route::patch('/admin/roles/{role}',[ 'as' => 'admin.roles.update', 'uses' => 'RoleController@update'])->middleware('auth');
Route::delete('/admin/roles/{role}',[ 'as' => 'admin.roles.destroy', 'uses' => 'RoleController@destroy'])->middleware('auth');
Route::get('/admin/userroles',[ 'as' => 'admin.roles.assignusers', 'uses' => 'RoleController@assignUsers'])->middleware('auth');
Route::get('/admin/userroles/{corpusproject}/{user}',[ 'as' => 'admin.roles.assignroletocpbyuser', 'uses' => 'RoleController@assignRolesToUsers'])->middleware('auth');
Route::get('/admin/userroles/{role}/{user}/delete',[ 'as' => 'admin.roles.deleteroleforuser', 'uses' => 'RoleController@removeRoleFromUser'])->middleware('auth');


/*
Route::resource('roles', 'RoleController');

*/
Route::group(array('prefix' => 'admin'), function() {
    Route::resource('permissions', 'PermissionController');
});

/** END ROLES  **/


Route::get('/viewFile/{path}',[ 'as' => 'gitRepo.readFile.route', 'uses' => 'GitRepoController@readFile'])->where('path', '.+')->middleware('auth');
Route::get('/corpusprojects/deleteFile/{path}',[ 'as' => 'gitRepo.deleteFile.route', 'uses' => 'GitRepoController@deleteFile'])->where('path', '.+')->middleware('auth');
Route::get('/corpusprojects/deleteDataFile/{path}',[ 'as' => 'gitRepo.deleteDataFile.route', 'uses' => 'GitRepoController@deleteDataFile'])->where('path', '.+')->middleware('auth');
Route::get('/corpusprojects/deleteUntrackedFile/{path}',[ 'as' => 'gitRepo.deleteUntrackedFile.route', 'uses' => 'GitRepoController@deleteUntrackedFile'])->where('path', '.+')->middleware('auth');
Route::get('/corpusprojects/deleteUntrackedDataFile/{path}',[ 'as' => 'gitRepo.deleteUntrackedDataFile.route', 'uses' => 'GitRepoController@deleteUntrackedDataFile'])->where('path', '.+')->middleware('auth');
Route::get('/updateFile/{path}',[ 'as' => 'gitRepo.updateFile.route', 'uses' => 'GitRepoController@updateFileVersion'])->where('path', '.+')->middleware('auth');


/** GIT **/
Route::get('/corpusprojects/addFiles/{path}/{corpus}',[ 'as' => 'gitRepo.addFile.route', 'uses' => 'GitRepoController@addFiles'])->where('path', '.+')->middleware('auth');
Route::get('/commitFiles/{dirname}/{commitmessage}/{corpus}',[ 'as' => 'gitRepo.commitFiles.route', 'uses' => 'GitRepoController@commitFiles'])->where('dirname', '.+')->middleware('auth');
Route::get('/commitMessage/{dirname}',[ 'as' => 'gitRepo.commit.route', 'uses' => 'CommitController@commitForm'])->where('dirname', '.+')->middleware('auth');
Route::post('/corpusprojects/commit',['as' => 'gitRepo.commit.post', 'uses' => 'CommitController@commitSubmit'])->middleware('auth');

/** END GIT **/


/** GITLAB **/
Route::get('/admin/gitlabgroups', ['as' => 'admin.gitlab.getGroups', 'uses' => 'GitLabController@listGroups'])->middleware('auth');
Route::get('/admin/gitlabgroups/{groupId}', ['as' => 'admin.gitlab.getGroups', 'uses' => 'GitLabController@showGitLabGroup'])->middleware('auth');
Route::get('/admin/gitlabgroups/create',[ 'as' => 'admin.gitlab.createGroup.', 'uses' => 'CorpusController@createGitLabGroup'])->middleware('auth');
/** END GITLAB **/



Route::get('/validatetei/{dirname}',['as' => 'gitRepo.validatetei.get', 'uses' => 'ValidateTEIController@validateFiles'])->where('dirname', '.+')->middleware('auth');


/*BROWSE */
Route::get('/browse/{header}/{id}', ['as' => 'browse.showHeaders.get', 'uses' => 'BrowseController@show']);