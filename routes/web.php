<?php


Auth::routes();
Route::get('/auth/{social}',['as' => 'auth.social.login', 'uses' => 'Auth\LoginController@socialLogin'])->where('social','twitter|facebook|linkedin|google|github|bitbucket|gitlab');
Route::get('/auth/{social}/callback',['as' => 'auth.social.callback', 'uses' => 'Auth\LoginController@handleProviderCallback'])->where('social','twitter|facebook|linkedin|google|github|bitbucket|gitlab');

Route::get('/', ['uses' => 'IndexController@index']);
Route::get('/admin', ['as' => 'admin', 'uses' => 'IndexController@admin'])->middleware('auth');




/** CORPUS PROJECTS  **/
Route::get('/admin/corpusprojects',[ 'as' => 'admin.corpusProject.index', 'uses' => 'CorpusProjectController@index'])->middleware('auth');
Route::get('/admin/corpusprojects/create',[ 'as' => 'admin.corpusProject.create.', 'uses' => 'CorpusProjectController@create'])->middleware('auth');
Route::get('/admin/corpusprojects/{corpusproject}',[ 'as' => 'admin.corpusProject.show.', 'uses' => 'CorpusProjectController@show'])->middleware('auth');
Route::post('/admin/corpusprojects',[ 'as' => 'admin.corpusProject.store.', 'uses' => 'CorpusProjectController@store'])->middleware('auth');
Route::get('/admin/corpusprojects/{corpusproject}/edit',[ 'as' => 'admin.corpusProject.edit', 'uses' => 'CorpusProjectController@edit'])->middleware('auth');
Route::get('/admin/corpusprojects/{corpusproject}/delete',[ 'as' => 'admin.corpusProject.delete', 'uses' => 'CorpusProjectController@delete'])->middleware('auth');
Route::get('/admin/corpusprojects/{corpusproject}/{user}/delete',[ 'as' => 'admin.usercorpusroles.destroy', 'uses' => 'CorpusProjectController@destroyCorpusProjectUser'])->middleware('auth');
Route::patch('/admin/corpusprojects/{corpusproject}',[ 'as' => 'admin.corpusProject.update', 'uses' => 'CorpusProjectController@update'])->middleware('auth');
Route::delete('/admin/corpusprojects/{corpusproject}',[ 'as' => 'admin.corpusProject.destroy', 'uses' => 'CorpusProjectController@destroy'])->middleware('auth');

Route::get('/admin/corpusprojects/assigncorpora/{corpusproject}',[ 'as' => 'admin.corpusProject.assignCorpora', 'uses' => 'CorpusProjectController@assignCorpora'])->middleware('auth');
Route::post('/admin/corpusprojects/{corpusproject}/corpora',[ 'as' => 'admin.corpusProject.assign.store.', 'uses' => 'CorpusProjectController@storeCorpusRelations'])->middleware('auth');
Route::get('/admin/corpusprojects/assignusers/{corpusproject}',[ 'as' => 'admin.corpusProject.assignusers', 'uses' => 'CorpusProjectController@assignUsers'])->middleware('auth');
Route::post('/admin/corpusprojects/{corpusproject}/users',[ 'as' => 'admin.corpusProject.StoreUsers', 'uses' => 'CorpusProjectController@storeUserRelations'])->middleware('auth');
/** END CORPUS PROJECTS  **/

/** CORPORA  **/
Route::get('/admin/corpora',[ 'as' => 'admin.corpora.index', 'uses' => 'CorpusController@index'])->middleware('auth');
Route::get('/admin/corpora/create/{corpusproject}',[ 'as' => 'admin.corpora.create.', 'uses' => 'CorpusController@create'])->middleware('auth');
Route::get('admin/corpora/assignusers/{corpus}',[ 'as' => 'admin.corpora.assignusers', 'uses' => 'CorpusController@assignCorpusUsers'])->middleware('auth');;
Route::get('/admin/corpora/{corpus}/{filepath}/show',[ 'as' => 'admin.corpora.show', 'uses' => 'CorpusController@show'])->where('filepath', '.+')->middleware('auth');
Route::post('/admin/corpora',[ 'as' => 'admin.corpora.store.', 'uses' => 'CorpusController@store'])->middleware('auth');
Route::get('/admin/corpora/{corpus}/edit',[ 'as' => 'admin.corpora.edit', 'uses' => 'CorpusController@edit'])->middleware('auth');
Route::get('/admin/corpora/{corpus}/delete',[ 'as' => 'admin.corpora.remove', 'uses' => 'CorpusController@delete'])->middleware('auth');
Route::get('/admin/corpora/{corpus}/{user}/delete',[ 'as' => 'admin.usercorpusroles.destroy', 'uses' => 'CorpusController@destroyCorpusUser'])->middleware('auth');
Route::patch('/admin/corpora/{corpus}',[ 'as' => 'admin.corpora.update', 'uses' => 'CorpusController@update'])->middleware('auth');
Route::delete('/admin/corpora/{corpus}',[ 'as' => 'admin.corpora.destroy', 'uses' => 'CorpusController@destroy'])->middleware('auth');
Route::get('/admin/corpora/{corpus}/{path?}',[ 'as' => 'admin.corpora.show', 'uses' => 'CorpusController@show'])->where('path', '.+')->middleware('auth');
/** END CORPORA  **/



/** UPLOAD **/
Route::get('/admin/upload/{dirname?}',['as' => 'gitRepo.upload.get', 'uses' => 'UploadController@uploadForm'])->where('dirname', '.+')->middleware('auth');
Route::post('/admin/upload',['as' => 'gitRepo.upload.post', 'uses' => 'UploadController@uploadSubmit'])->middleware('auth');
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

/** END ROLES  **/

Route::get('/search',['as' => 'search', 'uses' => 'SearchController@index']);

Route::get('/repository',[ 'as' => 'gitLab', 'uses' => 'GitLabController@listProjects'])->middleware('auth');


Route::get('/schema/{path?}',[ 'as' => 'gitRepo.route.schema', 'uses' => 'GitRepoController@listSchema'])->where('path', '.+')->middleware('auth');


Route::get('/viewFile/{path}',[ 'as' => 'gitRepo.readFile.route', 'uses' => 'GitRepoController@readFile'])->where('path', '.+')->middleware('auth');
Route::get('/admin/deleteFile/{path}',[ 'as' => 'gitRepo.deleteFile.route', 'uses' => 'GitRepoController@deleteFile'])->where('path', '.+')->middleware('auth');
Route::get('/updateFile/{path}',[ 'as' => 'gitRepo.updateFile.route', 'uses' => 'GitRepoController@updateFileVersion'])->where('path', '.+')->middleware('auth');


/** GIT **/
Route::get('/admin/addFiles/{path}/{corpus}',[ 'as' => 'gitRepo.addFile.route', 'uses' => 'GitRepoController@addFiles'])->where('path', '.+')->middleware('auth');
Route::get('/commitFiles/{dirname}/{commitmessage}/{corpus}',[ 'as' => 'gitRepo.commitFiles.route', 'uses' => 'GitRepoController@commitFiles'])->where('dirname', '.+')->middleware('auth');
Route::get('/commitMessage/{dirname}',[ 'as' => 'gitRepo.commit.route', 'uses' => 'CommitController@commitForm'])->where('dirname', '.+')->middleware('auth');
Route::post('/admin/commit',['as' => 'gitRepo.commit.post', 'uses' => 'CommitController@commitSubmit'])->middleware('auth');

/** END GIT **/


/** GITLAB **/
Route::get('/admin/gitlabgroups', ['as' => 'admin.gitlab.getGroups', 'uses' => 'GitLabController@listGroups'])->middleware('auth');
Route::get('/admin/gitlabgroups/{groupId}', ['as' => 'admin.gitlab.getGroups', 'uses' => 'GitLabController@showGitLabGroup'])->middleware('auth');
Route::get('/admin/gitlabgroups/create',[ 'as' => 'admin.gitlab.createGroup.', 'uses' => 'CorpusController@createGitLabGroup'])->middleware('auth');
/** END GITLAB **/

/** LDAP **/
Route::get('/ldapusers', ['as' => 'ldap.getUsers', 'uses' => 'LDAPController@index']);
/** END LDAP **/



/**OLD**/
Route::get('/createproject/{dirname?}',['as' => 'gitRepo.createproject.get', 'uses' => 'GitRepoController@createProjectForm'])->where('dirname', '.+')->middleware('auth');
Route::post('/createproject',['as' => 'gitRepo.createproject.post', 'uses' => 'GitRepoController@createProjectSubmit'])->middleware('auth');
Route::get('/projects/{path?}',[ 'as' => 'gitRepo.route', 'uses' => 'GitRepoController@listProjects'])->where('path', '.+')->middleware('auth');
/** END OLD **/

Route::get('/createcorpus/{dirname?}',['as' => 'gitRepo.createcorpus.get', 'uses' => 'GitRepoController@createCorpusForm'])->where('dirname', '.+')->middleware('auth');
Route::post('/createcorpus',['as' => 'gitRepo.createcorpus.post', 'uses' => 'GitRepoController@createCorpusSubmit'])->middleware('auth');


Route::get('/validatetei/{dirname}',['as' => 'gitRepo.validatetei.get', 'uses' => 'ValidateTEIController@validateFiles'])->where('dirname', '.+')->middleware('auth');


Route::get('/browse/{header}/{id}', ['as' => 'browse.showHeaders.get', 'uses' => 'BrowseController@index']);
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
