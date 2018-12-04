<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 19.10.17
 * Time: 11:33
 */
namespace App\Custom;
use Illuminate\Http\Request;

interface GitLabInterface {
    public function getGitLabGroups();
    public function showGitLabGroup($groupId);
    public function createGitLabGroup($name, $path, $description,$visibility);
    public function updateGitLabGroup($groupId,$params);
    public function deleteGitLabGroup($groupId);

    public function updateGitLabTag($gitLabId,$tagName,$releaseDescription);

    public function createGitLabProject($name, $path, $description,$visibility);
    public function deleteGitLabProject($projectId);
    public function unlinkProjectFromGroup($projectId,$groupId);
}