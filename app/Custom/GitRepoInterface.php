<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 06.07.17
 * Time: 17:12
 */
namespace App\Custom;
use Illuminate\Http\Request;

interface GitRepoInterface {
    public function createProjectFileStructure($flysystem,$projectName);
    public function createCorpusFileStructure($flysystem,$corpusProjectPath,$corpusName);
    public function updateCorpusFileStructure($flysystem,$corpusProjectPath,$oldCorpusPath,$corpusName);
    public function commitStagedFiles($corpusPath,$corpusId);
    public function hasCorpusFileStructure($flysystem , $corpusProjectPath, $corpusPath);
    public function checkForCorpusFiles($path);
    public function deleteCorpusFileStructure($flysystem, $path);
    public function deleteProjectFileStructure($flysystem, $path);
    public function getCorpusFiles($flysystem,$corpusid,$path = "");
    public function getCorpusDataFiles($flysystem,$path = "",$corpusId);
    public function getUploader($headerData,$headertype);
    public function getCorpusFileInfo($flysystem, $path = "",$corpusid);
    public function addFilesToRepository($path,$file);
    public function deleteFile($flysystem, $path,$user,$email);
    public function deleteUntrackedFile($flysystem,$path);
    public function addFiles($path);
    public function resetAdd($path,$files);
    public function commitFiles($dirname, $commitmessage, $corpusid,$user,$email);
    public function commitFile($dirname = "", $commitmessage, $corpusid, $user, $email);
    public function pushFiles($dirname,$corpusid,$user);
    public function addHooks($path,$user,$email);
    public function setGitConfig($path,$userEmail, $userName);
    public function initialPush($path,$user);
    public function addRemote($origin,$path);
    public function setCorpusVersionTag($corpusPath, $tagmessage, $version, $user,$email,$blame);

    /** HELPERS  **/
    public function filterDottedFiles($array);
    public function normalizeString ($str = '');
    public function normalizeTitle ($str = '');
    public function getCommitData($path);
}