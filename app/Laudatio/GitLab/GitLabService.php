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
use Gitlab\Api\AbstractApi;
use Gitlab\Client;


class GitLabService extends AbstractApi implements GitLabInterface {


    /**
     * The client
     *
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
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

    public function createGitLabProject($name, $groupId, $description = null,$visibility = 'public'){
        return GitLab::api('projects')->create($name, $groupId, $description, $visibility);
    }

    public function deleteGitLabProject($projectId){
        return GitLab::api('projects')->remove($projectId);
    }

    public function unlinkProjectFromGroup($projectId,$groupId){
        return $this->delete('projects/'.$this->encodePath($projectId).'/share/'.$this->encodePath($groupId));
    }

}