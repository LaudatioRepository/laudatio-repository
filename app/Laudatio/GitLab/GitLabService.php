<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 19.10.17
 * Time: 11:34
 */
namespace App\Laudatio\GitLab;

use App\Custom\GitLabInterface;
use Vinkla\GitLab\Facades\GitLab;
use Gitlab\Exception\ErrorException;

class GitLabService implements GitLabInterface {
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getGitLabGroups(){
        return GitLab::api('groups')->all();
    }

    public function showGitLabGroup($groupId){
        return GitLab::api('groups')->show($groupId);
    }

    public function createGitLabGroup($name, $path, $description = null, $visibility = 'internal'){
        return GitLab::api('groups')->create($name, $path, $description,$visibility);
    }
    public function updateGitLabGroup($groupId,$params){
        return GitLab::api('groups')->update($groupId,$params);
    }
    public function deleteGitLabGroup($groupId){
        return GitLab::api('groups')->remove($groupId);
    }


}