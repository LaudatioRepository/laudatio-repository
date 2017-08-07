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
    public function getCorpusFiles($flysystem,$path = "");
    public function addFilesToRepository($path,$file);

    /** HELPERS  **/
    public function filterDottedFiles($array);
    public function normalizeString ($str = '');
}