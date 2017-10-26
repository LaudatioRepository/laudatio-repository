<?php

namespace App\Http\Controllers;

use App\Custom\GitLabInterface;
use Response;
use Log;

class GitLabController extends Controller
{
    protected $GitLabService;

    public function __construct(GitLabInterface $GitLabService)
    {
        $this->GitLabService = $GitLabService;
    }

    function listGroups(){

        $data = $this->GitLabService->getGitLabGroups();
        return Response::json($data);
    }

    public function showGitLabGroup($groupId){
        $data = $this->GitLabService->showGitLabGroup($groupId);
        return Response::json($data);
    }
    public function createGitLabGroup($groupId){

    }

    public function createGitLabProject($name, $path, $description,$visibility){
        
    }
    public function updateGitLabGroup($groupId){}
    public function deleteGitLabGroup($groupId){}

}