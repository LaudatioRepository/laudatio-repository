<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Corpus;
use App\CorpusProject;
use App\MessageBoard;
use App\User;
use App\Role;
use App\Custom\GitRepoInterface;
use App\Custom\GitLabInterface;
use App\Custom\LaudatioUtilsInterface;
use GrahamCampbell\Flysystem\FlysystemManager;
use Illuminate\Support\Facades\Auth;
use Response;
use JavaScript;
use Log;

class CorpusController extends Controller
{
    protected $GitRepoService;
    protected $LaudatioUtilService;
    protected $flysystem;

    public function __construct(GitRepoInterface $Gitservice, FlysystemManager $flysystem,LaudatioUtilsInterface $laudatioUtils)
    {
        $this->GitRepoService = $Gitservice;
        $this->LaudatioUtilService = $laudatioUtils;
        $this->flysystem = $flysystem;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        $corpora = Corpus::latest()->get();

        $corpusProjects = array();

        foreach ($corpora as $corpus){
            $corpusProjectsTemp = $corpus->corpusprojects()->get();
            $cp = isset($corpusProjectsTemp[0]) ? $corpusProjectsTemp[0] : false;
            if($cp) {
                $corpusProjects[$corpus->id] = $corpusProjectsTemp[0]->directory_path;
            }
        }

        return view('/project.corpus.index', compact('corpora'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('corpusProjects', $corpusProjects)
            ->with('user',$user);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CorpusProject $corpusproject)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        $corpusProjectPath = $corpusproject->directory_path;
        $corpusProjectId = $corpusproject->gitlab_id;

        // Create the directory structure for the Corpus
        $corpusProjectPath = $corpusproject->directory_path;
        $corpusCount = count($corpusproject->corpora()->get());
        $corpus_name = "Untitled_".$corpusProjectId."_".($corpusCount++);
        $corpusPath = $this->GitRepoService->createCorpusFileStructure($this->flysystem,$corpusProjectPath,$corpus_name,$user);

        $corpus = null;
        $user_role = array();
        if($corpusPath){
            $corpus = Corpus::create([
                "name" => $corpus_name,
                "description" => "",
                'directory_path' => $corpusPath
            ]);

            $corpus->corpusprojects()->attach($corpusproject);


            $corpusAdminRole = Role::findById(3);
            $user->roles()->sync($corpusAdminRole);
            if($user) {
                if(!$user->roles->contains($corpusAdminRole)){
                    $user->roles()->attach($corpusAdminRole);
                }

                $corpus->users()->save($user,['role_id' => 3]);
                $user_role['user_name'] = $user->name;
                $user_role['user_id'] = $user->id;
                $user_role['role_name'] = $corpusAdminRole->name;
            }
        }


        $filePath = $corpusProjectPath.'/'.$corpus->directory_path;

        $corpus_data = array(
            'name' => $corpus->name,
            'project_name' => $corpusproject->name,
            'filepath' => $filePath,
            'admin' => $user_role

        );

        return redirect()->route('corpus.edit', compact('corpus'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('corpus_data', $corpus_data)
            ->with('user',$user);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            //'corpus_name' => 'required',
            'corpus_description' => 'required',
            'corpusProjectId' => 'required'
        ]);


        $corpusProject = CorpusProject::find(request('corpusProjectId'));
        $corpusProjectPath = $corpusProject->directory_path;
        $corpusProjectId = $corpusProject->gitlab_id;

        // Create the directory structure for the Corpus
        $corpusProjectPath = $corpusProject->directory_path;
        $corpusCount = count($corpusProject->corpora()->get());
        $corpus_name = "Untitled_".$corpusProjectId."_".($corpusCount++);
        $corpusPath = $this->GitRepoService->createCorpusFileStructure($this->flysystem,$corpusProjectPath,$corpus_name);


        if($corpusPath){
            $corpus = Corpus::create([
                "name" => $corpus_name,
                "description" => request('corpus_description'),
                'directory_path' => $corpusPath
            ]);

            $corpus->corpusprojects()->attach($corpusProject);
        }

        return redirect()->route('project.corpora.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_untitled(Request $request)
    {
        $this->validate(request(), [
            //'corpus_name' => 'required',
            'corpus_description' => 'required',
            'corpusProjectId' => 'required'
        ]);

        $corpusProject = CorpusProject::find(request('corpusProjectId'));

        // Create the directory structure for the Corpus
        $corpusProjectPath = $corpusProject->directory_path;
        $corpusProjectId = $corpusProject->gitlab_id;
        $corpusPath = null;
        /**
        if(request('corpus_name')){
            $corpusPath = $this->GitRepoService->createCorpusFileStructure($this->flysystem,$corpusProjectPath,request('corpus_name'));
        }
        else{

        }
         * */

        $corpusPath = "Untitled".$corpusProjectId;
        if($corpusPath){
            $corpus = Corpus::create([
                "name" => "Untitled",
                "description" => request('corpus_description'),
                'directory_path' => $corpusPath
            ]);
            $corpus->corpusprojects()->attach($corpusProject);
        }

        return redirect()->route('project.corpora.index');
    }

    /**
     * @param Corpus $corpus
     * @param string $path
     * @param string $show
     * @return $this
     */
    public function show(Corpus $corpus,$path = "",$show = "")
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        $corpusProjects = $corpus->corpusprojects()->get();
        $corpusProject_directory_path = '';

        $pathArray = explode("/",$path);
        end($pathArray);
        $last_id=key($pathArray);

        if(count($corpusProjects) == 1) {
            $corpusProject_directory_path = $corpusProjects->first()->directory_path;
        }
        else{
            // what to do when we can assign corpora to many projects?
        }

        $corpusPath = "";
        $corpus_directory_path = $corpus->directory_path;
        if($path == ""){
            $corpusPath = $corpusProject_directory_path."/".$corpus_directory_path;
        }
        else{
            $corpusPath = $path;
        }


        $fileData = array(
            "corpusData" => array(
                'path' => $corpusPath.'/CORPUS-DATA',
                'hasdir' => false
            ),
            "corpusDataFolder" => "",
            "headerData" => array(
                'path' => $corpusPath.'/TEI-HEADERS',
                'hasdir' => false
            ),
            "headerDataFolder" => "",
            "folderType" => ""
        );

        $folder = "";
        $folderType = "";
        $user_roles = array();
        if(strpos($corpusPath,"Untitled") === false){
            $corpusBasePath = $pathArray[0]."/".$pathArray[1];
            if(strpos($corpusPath,"CORPUS-DATA") !== false && strpos($corpusPath,"TEI-HEADERS") === false){
                $corpusData = $this->GitRepoService->getCorpusDataFiles($this->flysystem,$corpusPath,$corpus->id);
                $headerData = $this->GitRepoService->getCorpusFileInfo($this->flysystem,$corpusBasePath.'/TEI-HEADERS',$corpus->id);
                $folderType = "CORPUS-DATA";

            }
            else if(strpos($corpusPath,"TEI-HEADERS") !== false && strpos($corpusPath,"CORPUS-DATA") === false){
                $corpusData = $this->GitRepoService->getCorpusDataFiles($this->flysystem,$corpusBasePath.'/CORPUS-DATA',$corpus->id);
                $headerData = $this->GitRepoService->getCorpusFileInfo($this->flysystem,$corpusPath,$corpus->id);
                $folderType = "TEI-HEADERS";
            }
            else{
                $corpusData = $this->GitRepoService->getCorpusDataFiles($this->flysystem,$corpusPath.'/CORPUS-DATA',$corpus->id);
                $headerData = $this->GitRepoService->getCorpusFileInfo($this->flysystem,$corpusPath.'/TEI-HEADERS',$corpus->id);
            }

            $corpusDataFolder = substr($corpusData['path'],strrpos($corpusData['path'],"/")+1);
            $headerDataFolder = substr($headerData['path'],strrpos($headerData['path'],"/")+1);
            $fileData = array(
                "corpusData" => $corpusData,
                "corpusDataFolder" => $corpusDataFolder,
                "headerData" => $headerData,
                "headerDataFolder" => $headerDataFolder,
                "folderType" => $folderType
            );


            $corpusUsers = $corpus->users()->get();

            foreach ($corpusUsers as $corpusUser){
                if(!isset($user_roles[$corpusUser->id])){
                    $user_roles[$corpusUser->id] = array();
                }

                $role = Role::find($corpusUser->pivot->role_id);
                if($role){
                    array_push($user_roles[$corpusUser->id],$role->name);
                }

            }
        }
        //dd($corpusUsers );
/*
        return view("project.corpus.show",["corpus" => $corpus, "corpusproject_directory_path" => $corpusProject_directory_path, "fileData" => $fileData])
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user_roles',$user_roles)
            ->with('header', ucfirst($pathArray[$last_id]))
            ->with('user',$user);
*/
    }

    /**
     * @param Corpus $corpus
     * @return $this
     */
    public function edit(Corpus $corpus)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        $corpusProjects = $corpus->corpusprojects()->get();
        $corpusproject = null;
        $corpusProject_directory_path = '';

        if(count($corpusProjects) == 1) {
            $corpusproject = $corpusProjects->first();
            $corpusProject_directory_path = $corpusproject->directory_path;
        }

        $path = $corpusProject_directory_path.'/'.$corpus->directory_path;

        $corpusUsers = $corpus->users()->get();
        $corpus_admin = array();

        // get all roles
        $roleCollection = Role::all();
        $roles = array();
        foreach ($roleCollection as $role){
            $roles[$role->id] = $role->name;
        }
        ksort($roles);


        foreach ($corpusUsers as $corpusUser){
            $user_role = array();
            if(!isset($user_roles[$corpusUser->id])){
                $user_roles[$corpusUser->id] = array();
            }

            $role = Role::find($corpusUser->pivot->role_id);

            if($role){
                if($role->hasPermissionTo('Can create corpus')){
                    $corpus_admin['user_name'] = $corpusUser->name;
                    $corpus_admin['user_id'] = $corpusUser->id;
                    $corpus_admin['role_name'] = $role->name;
                    $corpus_admin['role_id'] = $role->id;
                }
                else {
                    $corpus_admin['user_name'] = "";
                    $corpus_admin['user_id'] = "";
                    $corpus_admin['role_name'] = "";
                    $corpus_admin['role_id'] = "";
                }
                $user_role['user_name'] = $corpusUser->name;
                $user_role['user_affiliation'] = $corpusUser->affiliation;
                $user_role['user_id'] = $corpusUser->id;
                $user_role['role_name'] = $role->name;
                $user_role['role_id'] = $role->id;

                array_push($user_roles[$corpusUser->id],$user_role);
            }
        }

        $checkResult = json_decode($this->GitRepoService->checkForCorpusFiles($path."/TEI-HEADERS"), true);
        $checkResult['corpusheader'] = ($checkResult['corpusheader'] == "") ? 0 : 1;


        //get filedata $flysystem,$corpus,$path = ""

        $folderData = $this->GitRepoService->getCorpusFiles($this->flysystem,$corpus->id, $path."/TEI-HEADERS");
        $corpusFileData = $this->GitRepoService->getCorpusFiles($this->flysystem,$corpus->id, $path."/TEI-HEADERS/corpus");
        $documentFileData = $this->GitRepoService->getCorpusFiles($this->flysystem,$corpus->id, $path."/TEI-HEADERS/document");
        $annotationFileData = $this->GitRepoService->getCorpusFiles($this->flysystem,$corpus->id, $path."/TEI-HEADERS/annotation");

        $corpusFormatData = $this->GitRepoService->getCorpusDataFiles($this->flysystem,$path."/CORPUS-DATA",$corpus->id);



        //get userinfo for the fileData
        $corpusnewelements = $this->GitRepoService->getUploader($corpusFileData['headerData']['elements'],'corpus');
        $corpusFileData['headerData']['elements'] = $corpusnewelements;

        $documentnewelements = $this->GitRepoService->getUploader($documentFileData['headerData']['elements'],'document');
        $documentFileData['headerData']['elements'] = $documentnewelements;

        $annotationnewelements = $this->GitRepoService->getUploader($annotationFileData['headerData']['elements'],'annotation');
        $annotationFileData['headerData']['elements'] = $annotationnewelements;

        //$formatfilenewelements = $this->GitRepoService->getUploader($corpusFormatData['fileData']['elements'],'formatfiles');
        //$formatFileData['headerData']['elements'] = $formatfilenewelements;




        $corpusUpload = false;
        if($corpus->gitlab_id == ""){
            $corpusUpload = true;
        }

        $documentUpload = false;
        $annotationUpload = false;

        if(count($corpus->annotations) == 0){
            $annotationUpload = true;
        }

        if(count($corpus->documents) == 0){
            $documentUpload = true;
        }

        $formatUpload = false;
        if(count($corpus->formatfiles) == 0) {
            $formatUpload = true;
        }

        // Get the messageboard for the CorpusProject this corpus is assigned to
        $messageboard = MessageBoard::where(['corpus_project_id' => $corpusproject->id])->get();
        $allMessages = array();
        $corpusMessages = array();
        $messagecount = 0;
        if(count($messageboard) > 0){
            $boardmessages = $messageboard[0]->boardmessages()->get();
            foreach ($boardmessages as $boardmessage) {

                $messageuser = User::findOrFail($boardmessage->user_id);
                $messageCorpus = Corpus::findOrFail($boardmessage->corpus_id);
                $message = array(
                    'user_name' => $messageuser->name,
                    'user_id' => $messageuser->id,
                    'corpus_id' => $boardmessage->corpus_id,
                    'corpus_name' => $messageCorpus->name,
                    'message' => $boardmessage->message,
                    'messageid' => $boardmessage->id,
                    'last_updated' => $boardmessage->updated_at,
                    'status' => $boardmessage->getStatus($boardmessage->status),
                    'status_id' => $boardmessage->status
                );

                if($corpus->id == $boardmessage->corpus_id){
                    $messagecount++;
                    array_push($corpusMessages,$message);
                }

                array_push($allMessages,$message);
            }
        }


        $corpus_data = array(
            'name' => $corpus->name,
            'project_name' => $corpusproject->name,
            'project_id' => $corpusproject->id,
            'filepath' => $path,
            'user_roles' => $user_roles,
            'roles' => $roles,
            'corpus_admin' => $corpus_admin,
            'headerdata' => $checkResult,
            'filedata' => array(
                'folderData' => $folderData,
                'corpusFileData' => $corpusFileData,
                'corpusUpload' => $corpusUpload,
                'documentFileData' => $documentFileData,
                'documentUpload' => $documentUpload,
                'annotationFileData' => $annotationFileData,
                'annotationUpload' => $annotationUpload,
                "formatUpload" => $formatUpload,
            ),
            'corpusFormatData' => $corpusFormatData,
            'boardmessages' => $corpusMessages,
            'allBoardMessages' => $allMessages,
            'messagecount' => $messagecount

        );
        //dd($corpus_data);
        JavaScript::put([
            'corpusUpload' => $corpusUpload,
            'documentUpload' => $documentUpload,
            'annotationUpload' => $annotationUpload,
            'corpus_id' => $corpus->id,
            'corpus_path' => $path,
            'auth_user_name' => $user->name,
            'auth_user_email' => $user->email,
        ]);

        return view('project.corpus.edit', compact('corpus'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('corpus_data', $corpus_data)
            ->with('user',$user);
    }

    /**
     * @param Request $request
     * @param Corpus $corpus
     * @return $this
     */
    public function update(Request $request, Corpus $corpus)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        $corpus->update([
            "name" => request('corpus_name'),
            "description" => request('corpus_description')
        ]);

        $corpusProjects = $corpus->corpusprojects()->get();
        $corpusproject = null;
        $corpusProject_directory_path = '';
        if(count($corpusProjects) == 1) {
            $corpusproject = $corpusProjects->first();
            $corpusProject_directory_path = $corpusproject->directory_path;
        }
        else{
            // what to do when we can assign corpora to many projects?
        }

        $corpora = $corpusproject->corpora()->get();

        $user_roles = array();
        $corpusProjectUsers = $corpusProjects->first()->users()->get();
        foreach ($corpusProjectUsers as $corpusProjectUser){
            if(!isset($user_roles[$corpusProjectUser->id])){
                $user_roles[$corpusProjectUser->id]['roles'] = array();
            }
            $user_roles[$corpusProjectUser->id]['user_name'] = $corpusProjectUser->name;

            $role = Role::find($corpusProjectUser->pivot->role_id);
            array_push($user_roles[$corpusProjectUser->id]['roles'],$role->name);
        }


        return view('project.corpusproject.show', compact('corpusproject'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('corpora',$corpora)
            ->with('user_roles',$user_roles)
            ->with('user',$user);
    }



    /**
     * @param Request $request
     * @return $this
     */
    public function destroy(Request $request)
    {

        $result = array();
        $status = "";

        try{
            $corpusid = $request->input('corpusid');
            $corpusPath = $request->input('path');
            $toBeDeleted = $request->input('tobedeleted');

            $corpus = Corpus::findOrFail($corpusid);

            $gitLabProjectId = $corpus->gitlab_id;
            $corpusProject = CorpusProject::find($projectId);

            $corpusPath = $corpusProject->directory_path.'/'.$corpus->directory_path;



            if(count($corpus->corpusprojects()) > 0) {
                $corpus->corpusprojects()->detach();
            }

            if(count($corpus->users()) > 0) {
                $corpus->users()->detach();
            }


            if(count($corpus->documents) > 0){
                foreach ($corpus->documents as $document){

                    if(count($document->annotations) > 0){
                        foreach ($document->annotations as $annotation){
                            if(count($annotation->documents()) > 0) {
                                $annotation->documents()->detach();
                            }
                            if(count($annotation->preparations) > 0) {
                                $annotation->preparations()->delete();
                            }
                        }//end for annotations
                        $document->annotations()->delete();
                    }//end if annotations
                }
                $corpus->documents()->delete();
            }

            if(count($corpus->annotations) > 0){
                $corpus->annotations()->delete();
            }

            if($gitLabProjectId != ""){
                $this->GitLabService->deleteGitLabProject($gitLabProjectId);
            }

            $corpus->delete();


            $this->GitRepoService->deleteCorpusFileStructure($this->flysystem,$corpusPath);

            $corpora = array();
            $corpora = Corpus::latest()->get();

            $corpusProjects = array();

            foreach ($corpora as $corpus){
                $corpusProjectsTemp = $corpus->corpusprojects()->get();
                $cp = isset($corpusProjectsTemp[0]) ? $corpusProjectsTemp[0] : false;
                if($cp){
                    $corpusProjects[$corpus->id] = $corpusProjectsTemp[0]->directory_path;
                }
            }

            $status = "success";
            $result['delete_corpus_content_response']  = "Corpus content was successfully deleted";

        }
        catch (\Exception $e) {
            $status = "error";
            $result['delete_corpus_content_response']  = "There was a problem deleting the Corpus content. The error was: ($e) A message has been sent to the site administrator. Please try again later";
        }


        $response = array(
            'status' => $status,
            'msg' => $result,
        );

        return Response::json($response);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function destroyCorpusContent(Request $request)
    {

        $result = array();
        $status = "";

        try{
            $corpusid = $request->input('corpusid');
            $corpusPath = $request->input('path');
            $auth_user_name = $request->input('auth_user_name');
            $auth_user_id = $request->input('auth_user_id');
            $auth_user_email = $request->input('auth_user_email');
            $toBeDeletedCollection = $request->input('tobedeleted');

            $corpus = Corpus::findOrFail($corpusid);

            foreach ($toBeDeletedCollection as $toBeDeleted) {
                if(!is_array($toBeDeleted)){
                    $toBeDeleted = json_decode($toBeDeleted);
                }

                $this->GitRepoService->deleteFile($this->flysystem,$corpusPath."/".$toBeDeleted['fileName'],$auth_user_name,$auth_user_email);
                DB::table('corpuses')
                    ->where([['id', '=' ,$deleteData['databaseId']],['corpus_id','=',$corpusid]])
                    ->update(['file_name' => null]);
            }

            $this->GitRepoService->pushFiles($corpusPath,$corpusid,$auth_user_name);

            $status = "success";
            $result['delete_corpus_content_response']  = "Corpus content was successfully deleted";

        }
        catch (\Exception $e) {
            $status = "error";
            $result['delete_corpus_content_response']  = "There was a problem deleting the Corpus content. The error was: ($e) A message has been sent to the site administrator. Please try again later";
        }


        $response = array(
            'status' => $status,
            'msg' => $result,
        );

        return Response::json($response);
    }


    /**
     * @param Corpus $corpus
     * @return $this
     */
    public function assignCorpusUsers(Corpus $corpus) {

        $isLoggedIn = \Auth::check();
        $loggedInUser = \Auth::user();
        $users = User::latest()->get();
        $filteredList = array();

        foreach ($users as $user){
            if(!$corpus->users->contains($user)){
                array_push($filteredList,$user);
            }
        }

        $user_roles = array();
        $corpusUsers = $corpus->users()->get();


        foreach ($corpusUsers as $corpusUser){
            $role = Role::find($corpusUser->pivot->role_id);

            if(!isset($user_roles[$corpusUser->pivot->role_id])){
                $user_roles[$corpusUser->pivot->role_id] = array();
            }
                array_push($user_roles[$corpusUser->pivot->role_id],$corpusUser->id);
        }

        /*
        $projects = $corpus->corpusprojects()->get();
        $project_user_roles = array();

        foreach ($projects as $project){
            $projectUsers = $project->users()->get();
            foreach ($projectUsers as $projectUser){
                $project_user_roles[$projectUser->id] = $projectUser->pivot->role_id;
            }
        }
*/
        $roles = Role::all();
        $filteredRoles = array();
        foreach ($roles as $role){
                if(
                    !$role->hasPermissionTo('Administer the application') &&
                    !$role->hasPermissionTo('Can create corpus project') &&
                    ($role->hasPermissionTo('Can create corpus')
                        || $role->hasPermissionTo('Can edit corpus')
                    )
                ){
                    array_push($filteredRoles,$role);
            }
        }

        //dd($filteredRoles);

        return view('project.corpus.assign_corpusroles_to_user')
            ->with('corpus', $corpus)
            ->with('users', $users)
            ->with('user',$loggedInUser)
            ->with('roles', $filteredRoles)
            ->with('user_roles',$user_roles)
            ->with('isLoggedIn', $isLoggedIn)
            ->with('loggedInUser',$loggedInUser);

    }

    public function storeRelationsByCorpus(Request $request)
    {

        $input =$request ->all();
        $msg = "";
        if ($request->ajax()){
            $msg .= "<p>Assigned the following roles to user </p>";
            $role_users = $input['role_users'];
            $corpus = Corpus::find($input['corpus_id']);
            $msg .= "<ul>";


            foreach($role_users as $roleId => $user_data) {
                $role = Role::find($roleId);
                if($role){
                    $msg .= "<li>".$role->name."<ul>";
                    foreach($user_data as $userId) {
                        $user = User::find($userId);

                        if($user) {
                            if(!$user->roles->contains($role)){
                                $user->roles()->attach($role);
                            }

                            $msg .= "<li>".$user->name."</li>";
                            $corpus->users()->save($user,['role_id' => $roleId]);

                        }

                    }
                    $msg .= "</ul></li>";
                }
            }//end foreach

            $msg .= "</ul>";
        }

        $response = array(
            'status' => 'success',
            'msg' => $msg,
        );

        return Response::json($response);
    }

    public function deleteRelationsByCorpus(Request $request){
        $input =$request ->all();
        $msg = "";
        if ($request->ajax()){

            $msg .= "<p>Removed the following user from the project: </p>";
            $userId = $input['userId'];
            $roleId = $input['roleId'];
            $corpus = Corpus::find($input['corpusId']);
            $user = User::find($userId);
            $corpus->users()->detach($userId);
            $msg .= "<ul>";
            $msg .= "<li>".$user->name."</li>";
            $msg .= "</ul>";
        }

        $response = array(
            'status' => 'success',
            'msg' => $msg,
        );

        return Response::json($response);
    }

    public function  destroyCorpusUser($corpusId,$userId){
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        $corpus = Corpus::find($corpusId);
        $corpus->users()->detach($userId);

        $roles = Role::latest()->get();
        return view('project.useradmin.roles.index', compact('roles'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

}
