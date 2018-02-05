<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\User;
use App\Role;
use App\Corpus;
use Log;

class DashboardController extends Controller
{

    /**
     * @return $this
     */
    public function index(){
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        $assignments = $this->userAssignments($user);
        //Log::info("assignments: ".print_r($assignments, 1));

        $corpora = $this->allCorpora();
        //Log::info("allcorpora: ".print_r($corpora, 1));
        //dd($corpora);

        return view('admin.dashboard.index')
            ->with('isLoggedIn', $isLoggedIn)
            ->with('assignments',$assignments)
            ->with('corpora',$corpora)
            ->with('user',$user);
    }

    public function allCorpora(){

        $corpora = array();

        $allCorpora = Corpus::all();

        foreach ($allCorpora as $corpus){
            $corpusProjects = $corpus->corpusprojects()->get();
            $corpora[$corpus->id] = array(
                "name" => $corpus->name,
                "directory_path" => $corpus->directory_path,
                "corpusUsers" => array(),
                "projectPath" => $corpusProjects[0]->directory_path,
                "projectId" => $corpusProjects[0]->id,
                "corpusAdmin" => array()
            );



            $corpusUsers = $corpus->users()->get();
            $corpusAdmin = "";
            $corpusAdminId = 0;
            $corpusAdminRoleId = 0;

            foreach ($corpusUsers as $corpusUser){
                if($corpusUser->id == $corpusUser->id){
                    $role = Role::find($corpusUser->pivot->role_id);
                    if(
                        $role->hasPermissionTo('Can create corpus') &&
                        !$role->hasPermissionTo('Can create corpus project') &&
                        !$role->hasPermissionTo('Administer the application')
                    ){
                        $corpusAdmin = $corpusUser->name;
                        $corpusAdminId = $corpusUser->id;
                        $corpusAdminRoleId = $role->id;
                        $corpora[$corpus->id]['corpusAdmin'] = array(
                            "name" => $corpusAdmin,
                            "id" => $corpusAdminId,
                            "roleId" => $corpusAdminRoleId
                        );
                    }
                    else{
                        array_push($corpora[$corpus->id]['corpusUsers'],array(
                                "name" => $corpusUser->name,
                                "id" => $corpusUser->id,
                                "role" => $role->name,
                                "roleId" => $role->id
                            )
                        );
                    }

                }
            }


        }
        return $corpora;
    }

    public function userAssignments(User $user){

        $assignments = array(
            "corpusProjects" => array(),
            "corpora" => array()
        );
        $corpus_projects = $user->corpus_projects()->get();
        $corpora = $user->corpora()->get();
        //dd($corpus_projects);

        foreach ($corpus_projects as $corpus_project){
            $projectUsers = $corpus_project->users()->get();
            foreach ($projectUsers as $projectUser){
                if($user->id == $projectUser->id){
                    $projectRole = Role::find($projectUser->pivot->role_id);

                    $assignments['corpusProjects'][$corpus_project->id] = array(
                        "name" => $corpus_project->name,
                        "role" => $projectRole->name,
                        "id" => $corpus_project->id
                    );
                }
            }
        }


        foreach ($corpora as $corpus){
            $corpusUsers = $corpus->users()->get();
            foreach ($corpusUsers as $corpusUser){
                if($user->id == $corpusUser->id){
                    $role = Role::find($corpusUser->pivot->role_id);

                    $corpus_corpus_project = $corpus->corpusprojects()->get();
                    $assignments['corpora'][$corpus->id] = array(
                        "corpus_name" => array(
                            "name" => $corpus->name,
                            "directory_path" => $corpus->directory_path
                        ),
                        "corpus_project" => array(
                            "name"=> $corpus_corpus_project[0]->name,
                            "directory_path"=> $corpus_corpus_project[0]->directory_path,
                            "id" =>$corpus_corpus_project[0]->id
                        ),
                        "role" => $role->name
                    );
                }
            }
        }
        return $assignments;
    }
}
