<?php

namespace App\Http\Controllers;

use Vinkla\GitLab\Facades\GitLab;

class GitLabController extends Controller
{
    protected $repoId;

    public function __construct()
    {
        $this->repoId = config('laudatio.repoid');
    }

    function listProjects(){
        $data = GitLab::api('projects')->show($this->repoId);
        $projects = array("uri" => $data['http_url_to_repo']);
        //print print_r($projects,1);
        return view("gitLab.projects",["projects" => $projects]);
    }
}