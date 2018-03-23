<?php


Auth::routes();
Route::get('/auth/{social}',['as' => 'auth.social.login', 'uses' => 'Auth\LoginController@socialLogin'])->where('social','twitter|facebook|linkedin|google|github|bitbucket|gitlab');
Route::get('/auth/{social}/callback',['as' => 'auth.social.callback', 'uses' => 'Auth\LoginController@handleProviderCallback'])->where('social','twitter|facebook|linkedin|google|github|bitbucket|gitlab');

Route::get('/', ['uses' => 'IndexController@index'])->middleware('auth');
Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index'])->middleware('auth');
Route::get('/admin', ['as' => 'admin', 'uses' => 'AdminController@index'])->middleware('auth');
Route::get('/browse', ['as' => 'browse', 'uses' => 'BrowseController@index']);
Route::get('/publish', ['as' => 'publish', 'uses' => 'IndexController@publish']);
Route::get('/schema/{path?}',[ 'as' => 'gitRepo.route.schema', 'uses' => 'GitRepoController@listSchema'])->where('path', '.+')->middleware('auth');
Route::get('/search',['as' => 'search', 'uses' => 'SearchController@index']);



/** CORPUS PROJECTS  **/
Route::get('/project/corpusprojects',[ 'as' => 'project.corpusProject.index', 'uses' => 'CorpusProjectController@index'])->middleware('auth');
Route::get('/project/corpusprojects/create',[ 'as' => 'project.corpusProject.create', 'uses' => 'CorpusProjectController@create'])->middleware('auth');
Route::get('/project/corpusprojects/{corpusproject}',[ 'as' => 'project.corpusProject.show', 'uses' => 'CorpusProjectController@show'])->middleware('auth');
Route::post('/project/corpusprojects',[ 'as' => 'project.corpusProject.store.', 'uses' => 'CorpusProjectController@store'])->middleware('auth');
Route::get('/project/corpusprojects/{corpusproject}/edit',[ 'as' => 'project.corpusProject.edit', 'uses' => 'CorpusProjectController@edit'])->middleware('auth');
Route::get('/project/corpusprojects/{corpusproject}/delete',[ 'as' => 'project.corpusProject.delete', 'uses' => 'CorpusProjectController@delete'])->middleware('auth');
Route::get('/project/corpusprojects/{corpusproject}/{user}/delete',[ 'as' => 'project.usercorpusroles.destroy', 'uses' => 'CorpusProjectController@destroyCorpusProjectUser'])->middleware('auth');
Route::patch('/project/corpusprojects/{corpusproject}',[ 'as' => 'project.corpusProject.update', 'uses' => 'CorpusProjectController@update'])->middleware('auth');
Route::delete('/project/corpusprojects/{corpusproject}',[ 'as' => 'project.corpusProject.destroy', 'uses' => 'CorpusProjectController@destroy'])->middleware('auth');

Route::get('/project/corpusprojects/assigncorpora/{corpusproject}',[ 'as' => 'project.corpusProject.assignCorpora', 'uses' => 'CorpusProjectController@assignCorpora'])->middleware('auth');
Route::post('/project/corpusprojects/{corpusproject}/corpora',[ 'as' => 'project.corpusProject.assign.store.', 'uses' => 'CorpusProjectController@storeCorpusRelations'])->middleware('auth');
Route::get('/project/corpusprojects/assignusers/{corpusproject}',[ 'as' => 'project.corpusProject.assignusers', 'uses' => 'CorpusProjectController@assignUsers'])->middleware('auth');
Route::post('/project/corpusprojects/{corpusproject}/users',[ 'as' => 'project.corpusProject.StoreUsers', 'uses' => 'CorpusProjectController@storeUserRelations'])->middleware('auth');
/** END CORPUS PROJECTS  **/

/** HEADERS  **/
Route::get('/project/corpora',[ 'as' => 'project.corpora.index', 'uses' => 'CorpusController@index'])->middleware('auth');
Route::get('/project/corpora/create/{corpusproject}',[ 'as' => 'project.corpora.create', 'uses' => 'CorpusController@create'])->middleware('auth');
Route::get('/project/corpora/{corpus}/edit',[ 'as' => 'project.corpora.edit', 'uses' => 'CorpusController@edit'])->middleware('auth');
Route::get('/project/corpora/{corpus}/delete/{corpusproject_directory_path}',[ 'as' => 'project.corpora.delete', 'uses' => 'CorpusController@delete'])->middleware('auth');
Route::get('project/corpora/assignusers/{corpus}',[ 'as' => 'project.corpora.assignusers', 'uses' => 'CorpusController@assignCorpusUsers'])->middleware('auth');;
Route::get('/project/corpora/{corpus}/{filepath}/show',[ 'as' => 'project.corpora.filepath.show', 'uses' => 'CorpusController@showFilePath'])->where('filepath', '.+')->middleware('auth');
Route::get('/project/corpora/{corpus}/{path?}',[ 'as' => 'project.corpora.show', 'uses' => 'CorpusController@show'])->where('path', '.+')->middleware('auth');
Route::post('/project/corpora',[ 'as' => 'project.corpora.store', 'uses' => 'CorpusController@store'])->middleware('auth');
Route::get('/project/corpora/{corpus}/{user}/delete',[ 'as' => 'project.usercorpusroles.destroy', 'uses' => 'CorpusController@destroyCorpusUser'])->middleware('auth');
Route::patch('/project/corpora/{corpus}',[ 'as' => 'project.corpora.update', 'uses' => 'CorpusController@update'])->middleware('auth');
Route::delete('/project/corpora/{corpus}/{projectId}',[ 'as' => 'project.corpora.destroy', 'uses' => 'CorpusController@destroy'])->middleware('auth');
/** END CORPORA  **/



/** UPLOAD **/
Route::get('/project/upload/{dirname?}',['as' => 'gitRepo.upload.get', 'uses' => 'UploadController@uploadForm'])->where('dirname', '.+')->middleware('auth');
Route::get('/project/uploadFiles/{dirname?}',['as' => 'gitRepo.uploadFiles.get', 'uses' => 'UploadController@uploadDataForm'])->where('dirname', '.+')->middleware('auth');
Route::post('/project/upload',['as' => 'gitRepo.upload.post', 'uses' => 'UploadController@uploadSubmit'])->middleware('auth');
Route::post('/project/uploadFiles',['as' => 'gitRepo.uploadFiles.post', 'uses' => 'UploadController@uploadSubmitFiles'])->middleware('auth');
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
Route::get('/project/deleteFile/{path}',[ 'as' => 'gitRepo.deleteFile.route', 'uses' => 'GitRepoController@deleteFile'])->where('path', '.+')->middleware('auth');
Route::get('/project/deleteDataFile/{path}',[ 'as' => 'gitRepo.deleteDataFile.route', 'uses' => 'GitRepoController@deleteDataFile'])->where('path', '.+')->middleware('auth');
Route::get('/project/deleteUntrackedFile/{path}',[ 'as' => 'gitRepo.deleteUntrackedFile.route', 'uses' => 'GitRepoController@deleteUntrackedFile'])->where('path', '.+')->middleware('auth');
Route::get('/project/deleteUntrackedDataFile/{path}',[ 'as' => 'gitRepo.deleteUntrackedDataFile.route', 'uses' => 'GitRepoController@deleteUntrackedDataFile'])->where('path', '.+')->middleware('auth');
Route::get('/updateFile/{path}',[ 'as' => 'gitRepo.updateFile.route', 'uses' => 'GitRepoController@updateFileVersion'])->where('path', '.+')->middleware('auth');


/** GIT **/
Route::get('/project/addFiles/{path}/{corpus}',[ 'as' => 'gitRepo.addFile.route', 'uses' => 'GitRepoController@addFiles'])->where('path', '.+')->middleware('auth');
Route::get('/commitFiles/{dirname}/{commitmessage}/{corpus}',[ 'as' => 'gitRepo.commitFiles.route', 'uses' => 'GitRepoController@commitFiles'])->where('dirname', '.+')->middleware('auth');
Route::get('/commitMessage/{dirname}',[ 'as' => 'gitRepo.commit.route', 'uses' => 'CommitController@commitForm'])->where('dirname', '.+')->middleware('auth');
Route::post('/project/commit',['as' => 'gitRepo.commit.post', 'uses' => 'CommitController@commitSubmit'])->middleware('auth');

/** END GIT **/


/** GITLAB **/
Route::get('/admin/gitlabgroups', ['as' => 'admin.gitlab.getGroups', 'uses' => 'GitLabController@listGroups'])->middleware('auth');
Route::get('/admin/gitlabgroups/{groupId}', ['as' => 'admin.gitlab.getGroups', 'uses' => 'GitLabController@showGitLabGroup'])->middleware('auth');
Route::get('/admin/gitlabgroups/create',[ 'as' => 'admin.gitlab.createGroup.', 'uses' => 'CorpusController@createGitLabGroup'])->middleware('auth');
/** END GITLAB **/



Route::get('/validatetei/{dirname}',['as' => 'gitRepo.validatetei.get', 'uses' => 'ValidateTEIController@validateFiles'])->where('dirname', '.+')->middleware('auth');


/*BROWSE */
Route::get('/browse/{header}/{id}', ['as' => 'browse.showHeaders.get', 'uses' => 'BrowseController@index']);