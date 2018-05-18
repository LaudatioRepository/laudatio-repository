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
    public function commitStagedFiles($corpusPath);
    public function hasCorpusFileStructure($flysystem , $corpusProjectPath, $corpusPath);
    public function checkForCorpusFiles($path);
    public function deleteCorpusFileStructure($flysystem, $path);
    public function deleteProjectFileStructure($flysystem, $path);
    public function getCorpusFiles($flysystem,$corpusid,$path = "");
    public function getCorpusFileInfo($flysystem, $path = "");
    public function addFilesToRepository($path,$file);
    public function deleteFile($flysystem, $path);
    public function deleteUntrackedFile($flysystem,$path);
    public function addFiles($path,$corpus);
    public function commitFiles($dirname, $commitmessage, $corpusid,$user);
    public function pushFiles($dirname,$corpusid,$user);
    public function initialPush($path,$user);
    public function addRemote($origin,$path);

    /** HELPERS  **/
    public function filterDottedFiles($array);
    public function normalizeString ($str = '');
    public function normalizeTitle ($str = '');
    public function getCommitData($path);
}