<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 25.04.17
 * Time: 15:33
 */

namespace App\Laudatio\GitLaB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Log;

class GitFunction
{
    protected $repoId;
    protected $basePath;

    public function __construct()
    {
        $this->repoId = config('laudatio.repoid');
        $this->basePath = config('laudatio.basePath');
    }

    public function getStatus($path){
        $process = new Process("git status",$path);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    public function doAdd($path){

        if(is_dir($path)){
            $process = new Process("git add .",$path);
        }
        else{
            $pathWithOutAFile = substr($path,0,strrpos($path,"/"));
            $file = substr($path,strrpos($path,"/")+1);
            $cwdPath = $this->basePath."/".$pathWithOutAFile;
            $process = new Process("git add $file",$cwdPath);
        }

        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }


    public function doAddFile($file,$path){
        $process = new Process("git add $file",$path);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }


    public function isUntracked($status){
        return (strpos($status,"untracked files present") !== false);
    }

    public function isTracked($path){
        $isTracked = false;
        $pathWithOutAddedFolder = substr($path,0,strrpos($path,"/"));
        $folder = substr($path,strrpos($path,"/")+1);

        $process = new Process("git ls-files --others --exclude-standard $folder",$pathWithOutAddedFolder);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }


        if($process->getOutput() == ""){
            $isTracked = true;
        }


        return $isTracked;
    }

    public function hasDiff($path){
        $hasDiff = null;

        $pathWithOutAddedFolder = substr($path,0,strrpos($path,"/"));
        $folder = substr($path,strrpos($path,"/")+1);

        $process = new Process("git diff --name-only",$pathWithOutAddedFolder);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        if($process->getOutput() != ""){
            $hasDiff = $process->getOutput();
        }

        return $hasDiff;
    }

    public function fileHasDiff($path, $file){
        $fileHasDiff = false;

        //$pathWithOutAddedFolder = substr($path,0,strrpos($path,"/"));
        $folder = substr($path,strrpos($path,"/")+1);

        $process = new Process("git diff $file",$path);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        if($process->getOutput() != ""){
            $fileHasDiff = true;
        }

        return $fileHasDiff;
    }


    public function isAdded($status){
        return (strpos($status,"Changes to be committed") !== false || strpos($status,"\"use git add\" and/or \"git commit -a\"") !== false);
    }

    public function isModified($status){
        return (strpos($status,"modified:") !== false && strpos($status, 'Changes not staged for commit') !== false);
    }

    public function isModifiedAndAdded($status){
        return (strpos($status,"Changes to be committed") !== false && strpos($status,"modified:") !== false);
    }

    public function isCommitted2($status){
        return (strpos($status,"file changed,") !== false);
    }

    public function isCommitted($commitmessage, $logmessage){
        return (strpos($logmessage,$commitmessage) !== false);
    }

    public function isReadyForPush($status){
        return (strpos($status,"use \"git push\" to publish your local commits") !== false);
    }

    public function isCleanWorkingTree($status){
        return(strpos($status,"working tree clean") !== false);
    }

    public function getLogMessage($nummer,$path){
        $process = new Process("git log -".$nummer." --pretty=%B",$path);
        $process->run();
        $logMessage = "";

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        else {
            $logMessage = $process->getOutput();
        }
        return $logMessage;
    }

    public function addUntracked($pathWithOutAddedFolder, $folder = ""){
        $isAdded = false;
        $status = $this->getStatus($this->basePath."/".$pathWithOutAddedFolder);

        if($folder == ""){
            if($this->isUntracked($status)){
                $addResult = $this->doAdd($this->basePath."/".$pathWithOutAddedFolder);
                $addStatus = $this->getStatus($this->basePath."/".$pathWithOutAddedFolder);
                if($this->isAdded($addStatus)){
                    $isAdded = true;
                }
            }
        }
        else {
            if(!$this->isTracked($this->basePath."/".$pathWithOutAddedFolder."/".$folder)){

                if (is_dir($folder)) {
                    $addResult = $this->doAdd($this->basePath."/".$pathWithOutAddedFolder."/".$folder);
                }
                else{

                    $addResult = $this->doAddFile($folder,$this->basePath."/".$pathWithOutAddedFolder);
                }

                $addStatus = $this->getStatus($this->basePath."/".$pathWithOutAddedFolder);
                if($this->isAdded($addStatus)){
                    $isAdded = true;
                }
            }
        }

        return $isAdded;
    }


    public function addModified($pathWithOutAddedFolder, $folder = ""){
        $isAdded = false;
        $status = $this->getStatus($this->basePath."/".$pathWithOutAddedFolder);

        if($folder == ""){
            /**
             * @todo
             */
        }
        else {
            $this->doAddFile($folder, $this->basePath."/".$pathWithOutAddedFolder);
            $addStatus = $this->getStatus($this->basePath."/".$pathWithOutAddedFolder);
            $isAdded = $this->isModifiedAndAdded($addStatus);
        }

        return $isAdded;
    }

    public function commitFiles($path, $commitmessage){
        $isCommitted = false;
        $process = new Process("git commit -m \"".$commitmessage."\" ",$path);
        $process->setTimeout(3600);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        else{
            $processOutput = $process->getOutput();
            if($this->isCommitted($commitmessage,$processOutput)){
                $isCommitted = true;
                //$status = $this->getStatus($this->basePath."/".$path);
            }
        }

        return $isCommitted;
    }



    public function addFileUpdate($path, $file){
        $isAdded = false;

        if($this->fileHasDiff($this->basePath."/".$path,$file)){
            $addStatus = $this->getStatus($this->basePath."/".$path);
            $modifiedStatus = $this->isModified($addStatus);
            if($modifiedStatus == 1){
                $isAdded = $this->addModified($path,$file);
            }
        }

        return $isAdded;
    }

    public function initiateRepository($path){
        $isInitiated = false;
        $process = new Process("git init",$this->basePath."/".$path);
        $process->setTimeout(3600);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        else{
            $processOutput = $process->getOutput();
            $isInitiated = true;
        }
        return $isInitiated;
    }

    public function copyGitHooks($path){
        $isCopied = false;
        /*
         * cp ../../../scripts/githooks/* .git
         */
        $hookProcess = new Process("cp ../../../scripts/githooks/* .git/hooks",$this->basePath."/".$path);
        $hookProcess->run();
        // executes after the command finishes
        if (!$hookProcess->isSuccessful()) {
            throw new ProcessFailedException($hookProcess);
        }
        else{
            $processOutput = $hookProcess->getOutput();
            $isCopied = true;
        }

        return $isCopied;
    }

    public function copyScripts($path){
        $isCopied = false;

        $makeDirectoryProcess = new Process("mkdir .git/src",$this->basePath."/".$path);
        $makeDirectoryProcess->run();
        if (!$makeDirectoryProcess->isSuccessful()) {
            throw new ProcessFailedException($makeDirectoryProcess);
        }
        else{
            $scriptProcess = new Process("cp ../../../scripts/src/* .git/src",$this->basePath."/".$path);
            $scriptProcess->run();
            // executes after the command finishes
            if (!$scriptProcess->isSuccessful()) {
                throw new ProcessFailedException($scriptProcess);
            }
            else{
                $processOutput = $scriptProcess->getOutput();
                $isCopied = true;
            }
        }

        return $isCopied;
    }

    /**
     * @param $dirPath
     * @param $fileDataArray
     * @return string
     */
    public function writeFiles($dirPath, $fileDataArray,$flySystem,$fileTempPath,$theFilePath){

        foreach($fileDataArray as $fileData) {
            $pathsArray = explode("/", $fileData);
            $fileInDirectory = array_pop($pathsArray);
            $createdDirectoryPath = array();
            if($this->isDottedFile($fileInDirectory) === false){
                foreach ($pathsArray as $path) {
                    $created = "";
                    if (count($createdDirectoryPath) ==  0) {
                        $singlePath = $dirPath."/".$path;

                        if(!file_exists($this->basePath."/".$singlePath)){
                            $created = $this->makeDirectory($dirPath, $path);
                        }
                        else{
                            array_push($createdDirectoryPath,$path);
                        }
                    } else {
                        $combinedPath = $dirPath."/".implode("/", $createdDirectoryPath);
                        if(!file_exists($this->basePath."/".$combinedPath."/".$path)){
                            $created = $this->makeDirectory($combinedPath, $path);
                        }
                        else{
                            array_push($createdDirectoryPath,$path);
                        }
                    }


                    if ($created != "") {
                        array_push($createdDirectoryPath,$created);
                    }
                }
            }
        }

        //write file if exists
        $fileArray = explode("/", $theFilePath);
        $fileInDirectory = array_pop($fileArray);
        $savePath = implode("/",$fileArray);

        if(file_exists($this->basePath."/".$dirPath."/".$savePath)){
            $existingFile = $flySystem->has($dirPath."/".$savePath."/".$fileInDirectory);
            if(!$existingFile){
                $stream = fopen($fileTempPath, 'r+');
                $flySystem->writeStream($dirPath."/".$savePath."/".$fileInDirectory, $stream);
            }
            else{
                $stream = fopen($fileTempPath, 'r+');
                $flySystem->updateStream($dirPath."/".$savePath."/".$fileInDirectory, $stream);
            }
        }

        return $createdDirectoryPath;
    }

    public function makeDirectory($path,$directory){
        $createdDirectoryPath = "";
        $makeDirectoryProcess = new Process("mkdir $directory",$this->basePath."/".$path);
        $makeDirectoryProcess->run();
        if (!$makeDirectoryProcess->isSuccessful()) {
            throw new ProcessFailedException($makeDirectoryProcess);
        }
        else{
            $createdDirectoryPath = $directory;
        }
        return $createdDirectoryPath;
    }


    public function deleteFiles($path){

        $isdeleted = false;
        $isFile = false;
        $pathWithOutAddedFolder = "";
        $folder = "";
        $cwdPath = "";


        if(!is_dir($this->basePath.'/'.$path)){
            $isFile = true;
        }

        if(strpos($path,"/") !== false){
            $pathWithOutAddedFolder = substr($path,0,strrpos($path,"/"));
            $folder = substr($path,strrpos($path,"/")+1);
            $cwdPath = $this->basePath."/".$pathWithOutAddedFolder;
        }
        else{
            $cwdPath = $this->basePath;
            $folder = $path;
        }

        $trackstatus = $this->getStatus($cwdPath);

        $process = null;
        $folder = str_replace(" ","\\ ",$folder);
        //dd("FOLDER: ".$folder." CWDPATH: ".$cwdPath);

        if($isFile){
            $process = new Process("git rm $folder",$cwdPath);
        }
        else{
            $process = new Process("git rm -rf *",$cwdPath);
        }


        $process->run();


        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        else{

            $addStatus = $this->getStatus($cwdPath);
            if($this->isAdded($addStatus)){


                $commit = $this->commitFiles($cwdPath,"deleting $cwdPath/$folder");
                $commitstatus = $this->getStatus($cwdPath);

                if($this->isCleanWorkingTree($commitstatus)){
                    $isdeleted = true;
                }
            }
        }

        return $isdeleted;
    }


    public function deleteUntrackedFiles($path){

        $isdeleted = false;
        $isFile = false;
        $pathWithOutAddedFolder = "";
        $folder = "";
        $cwdPath = "";


        if(!is_dir($this->basePath.'/'.$path)){
            $isFile = true;
        }

        if(strpos($path,"/") !== false){
            $pathWithOutAddedFolder = substr($path,0,strrpos($path,"/"));
            $folder = substr($path,strrpos($path,"/")+1);
            $cwdPath = $this->basePath."/".$pathWithOutAddedFolder;
        }
        else{
            $cwdPath = $this->basePath;
            $folder = $path;
        }

        $process = null;
        $folder = str_replace(" ","\\ ",$folder);

        $process = new Process("rm -rf $folder",$cwdPath);
        $process->run();


        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        else{
            $isdeleted = true;
        }

        return $isdeleted;
    }

    public function getCommitData($path){
        $process = new Process("git show -s",$this->basePath.'/'.$path);
        $process->run();

        // executes after the command finishes
        $commitData = array();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        else{
            $processOutput = $process->getOutput();

            //parse the output
            $stringArray = explode("\n",$processOutput);

            $sha_string_arr = explode(" ",$stringArray[0]);
            $sha_string = trim($sha_string_arr[1]);
            $commitData["sha_string"] = $sha_string;

            $author_string_arr = explode(":",$stringArray[1]);
            $author = trim($sha_string_arr[1]);
            $commitData["author"] = $author;

            $date_string_arr = explode(":",$stringArray[2]);
            $date = $date_string_arr[1];
            $commitData["date"] = $date;

            $message = trim($stringArray[4]);
            $commitData["message"] = $message;

        }
        return $commitData;
    }

    public function isDottedFile($file){
        return strpos($file,".") == 0;
    }
}