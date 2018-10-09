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
use DB;
use Log;

class GitFunction
{
    protected $repoId;
    protected $basePath;
    protected $scriptPath;

    public function __construct()
    {
        $this->repoId = config('laudatio.repoid');
        $this->basePath = config('laudatio.basePath');
        $this->scriptPath = config('laudatio.scriptPath');
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

    public function addGitHooks($path, $user, $email) {
        $isAdded = false;

        $process = new Process("git add githooks",$this->basePath."/".$path);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        else{
            $processOutput = $process->getOutput();
            $isAdded = true;
        }

        return $isAdded;
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

        $process = new Process("git ls-files --others --exclude-standard \"$folder\"",$pathWithOutAddedFolder);
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

        $process = new Process("git diff \"$file\"",$path);
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

    public function fileExists($path){
        return file_exists($this->basePath."/".$path);
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

    public function commitFiles($path, $commitmessage, $user, $email){
        $isCommitted = false;

        $process = new Process("git commit -m \"".$commitmessage." by ".$user." (".$email.") \" ",$path);
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
            }
        }

        return $isCommitted;
    }

    public function commitFile($path,$file, $commitmessage, $user, $email){
        $isCommitted = false;
        Log::info("comittmessage: : ".$commitmessage." ".$file. " by ".$user." (".$email.") \"");
        $process = new Process("git commit -m \"".$commitmessage." ".$file. " by ".$user." (".$email.") \" ".$file,$path);
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
            }
        }

        return $isCommitted;
    }

    public function setCorpusVersionTag($corpusPath, $tagmessage, $version, $user,$email, $blame) {
        $isTagged = false;
        $process = null;
        if($blame) {
            $process = new Process(" git tag -a v".$version." -m \"".$tagmessage." by ".$user." (".$email.") \" ",$this->basePath."/".$corpusPath);
        }
        else {
            $process = new Process(" git tag -a v".$version." -m \"".$tagmessage."\"",$this->basePath."/".$corpusPath);
        }

        $process->setTimeout(3600);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            Log::info ("THERE WAS A PROCESS ERROR: ".print_r($process->getErrorOutput(),1));
            throw new ProcessFailedException($process);
        }
        else{
            $processOutput = $process->getOutput();

            if($this->isTagged($version,$this->basePath."/".$corpusPath)){

                $push_process = new Process(" git push origin v".$version,$this->basePath."/".$corpusPath);
                $push_process->setTimeout(3600);
                $push_process->run();

                if (!$push_process->isSuccessful()) {
                    throw new ProcessFailedException($push_process);
                }
                else{
                    $isTagged = true;
                }
            }
        }
        return $isTagged;
    }

    public function isTagged($version,$corpusPath) {
        $isTagged = false;

        $process = new Process(" git tag",$corpusPath);
        $process->setTimeout(3600);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        else{
            $processOutput = $process->getOutput();
            Log::info ("CHEKING IF TAGGED: ".print_r($processOutput,1)." => ".print_r($version,1));
            if(strpos($processOutput, strval($version)   ) !== false){
                $isTagged = true;
            }
        }
        return $isTagged;
    }

    public function addRemote($origin,$path) {
        $addedRemote = false;
        $shouldAdd = false;

        $askForOriginProcess = new Process("git remote -v",$this->basePath."/".$path);
        $askForOriginProcess->setTimeout(3600);
        $askForOriginProcess->run();


        if (!$askForOriginProcess->isSuccessful()) {
            throw new ProcessFailedException($askForOriginProcess);
        }
        else{
            $askForOriginProcessOutput = $askForOriginProcess->getOutput();
            if(empty($askForOriginProcessOutput)){
                $shouldAdd = true;
            }
        }



        if($shouldAdd){
            //Log::info("trying to: git remote add origin ".$origin." => ".$this->basePath."/".$path);
            $process = new Process("git remote add origin ".$origin,$this->basePath."/".$path);
            $process->setTimeout(3600);
            $process->run();
        }
        else{
            //Log::info("trying to: git remote set-url origin ".$origin." => ".$this->basePath."/".$path);
            $process = new Process("git remote set-url origin ".$origin,$this->basePath."/".$path);
            $process->setTimeout(3600);
            $process->run();
        }

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        else{
            $processOutput = $process->getOutput();
            $addedRemote = true;
        }
        return $addedRemote;
    }

    public function initialPush($path,$user){
        //git push --set-upstream origin master
        $isPushed = false;
        $process = new Process("git push --set-upstream origin master",$this->basePath."/".$path);
        $process->setTimeout(3600);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        else{
            $processOutput = $process->getOutput();
            $isPushed = true;
        }
        return $isPushed;
    }

    public function resetAdd($path,$files){
        $isReset = false;
        foreach($files as $file) {
            //git reset -- main/*
            $process = null;
            if(is_dir($file)){
                $process = new Process("git reset -- ".$file."/*",$this->basePath."/".$path);
            }
            else{
                $process = new Process("git reset -- $file",$this->basePath."/".$path);
            }

            $process->setTimeout(3600);
            $process->run();

            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            else{
                $processOutput = $process->getOutput();
                $isReset = true;
            }
        }
        return $isReset;
    }

    public function pushFiles($path,$corpusid) {
        $isPushed = false;
        $process = new Process("git push",$this->basePath."/".$path);
        $process->setTimeout(3600);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        else{
            $processOutput = $process->getOutput();
            $isPushed = true;
        }
        return $isPushed;
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
        $hookProcess = new Process("cp ".$this->scriptPath."/githooks/* githooks",$this->basePath."/".$path);
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


    public function setGitConfig($path,$configs) {
        $listOfErrors = array();
        foreach ($configs as $config) {
            $process = new Process("git config ".$config,$this->basePath."/".$path);
            $process->run();
            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            else{
                array_push($listOfErrors, $process->getOutput());

            }
        }
        return $listOfErrors;
    }


    public function setCoreHooksPath($path){
        $isSet = false;
        /*
         * cp ../../../scripts/githooks/* .git
         */
        $hookProcess = new Process('printf "\t hooksPath = githooks\n" >> .git/config',$this->basePath."/".$path);
        $hookProcess->run();
        // executes after the command finishes
        if (!$hookProcess->isSuccessful()) {
            throw new ProcessFailedException($hookProcess->getErrorOutput());
        }
        else{
            $processOutput = $hookProcess->getOutput();
            $isSet = true;
        }

        return $isSet;
    }

    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
    }

    public function copyScripts($path){
        $isCopied = false;

        $makeDirectoryProcess = new Process("mkdir .git/src",$this->basePath."/".$path);
        $makeDirectoryProcess->run();
        if (!$makeDirectoryProcess->isSuccessful()) {
            throw new ProcessFailedException($makeDirectoryProcess);
        }
        else{
            $scriptProcess = new Process("cp ".$this->scriptPath."/src/* .git/src",$this->basePath."/".$path);
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




        #if(file_exists($this->basePath."/".$dirPath."/".$fileInDirectory)){

            $stream = null;
            $fileInDirectory = "";
            $writePath = "";

            if(strpos($theFilePath,'images') !== false) {
                $writePath = $theFilePath;
                $flySystem->has($theFilePath);
            }
            else{
                //write file if exists
                $fileArray = explode("/", $theFilePath);


                if(count($fileArray) == 1){
                    $fileInDirectory = array_pop($fileArray);
                }

                $writePath = $dirPath."/".$fileInDirectory;
            }


            $existingFile = $flySystem->has($dirPath."/".$fileInDirectory);

            if(!$existingFile){
                $stream = fopen($fileTempPath, 'r+');
                $flySystem->writeStream($writePath, $stream);
            }
            else{
                $stream = fopen($fileTempPath, 'r+');
                $flySystem->updateStream($writePath, $stream);
            }
        #}
        array_push($createdDirectoryPath,$this->basePath."/".$writePath);

        if (is_resource($stream)) {
            fclose($stream);
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

    public function renameFile($path,$oldname,$newname){
        $renamedPath = "";
        $makeDirectoryProcess = new Process("mv $oldname $newname",$this->basePath."/".$path);
        $makeDirectoryProcess->run();
        if (!$makeDirectoryProcess->isSuccessful()) {
            throw new ProcessFailedException($makeDirectoryProcess);
        }
        else{
            $renamedPath = $path."/".$newname;
        }
        return $renamedPath;
    }


    public function deleteFiles($path,$user,$email){

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


                $commit = $this->commitFiles($cwdPath,"deleting $cwdPath/$folder",$user,$email);
                $commitstatus = $this->getStatus($cwdPath);

                if($this->isCleanWorkingTree($commitstatus)){
                    clearstatcache(TRUE);
                    $isdeleted = true;
                }
            }
        }

        return $isdeleted;
    }

    public function deleteUntrackedDataFiles($path){
        $isFile = false;
        $isDeleted = false;
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
        if($isFile){
            $process = new Process("rm $folder",$cwdPath);
        }
        else{
            $process = new Process("rm -rf *",$cwdPath);
        }

        $process->run();


        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        else{
            $isDeleted = true;
        }

        return $isDeleted;
    }

    public function deleteUntrackedFiles($path,$isProject = false,$isCorpus = false){

        $isdeleted = false;
        $isFile = false;
        $pathWithOutAddedFolder = "";
        $folder = "";
        $cwdPath = "";

        if(!is_dir($this->basePath.'/'.$path)){
            $isFile = true;
        }

        if($isFile){
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
        }
        else{
            //we are deleting contents of a folder
            $dirArray = explode("/",$path);
            //dd($dirArray);
            if(!$isCorpus && !$isProject){
                $type = $dirArray[3];
                $objects = null;
                switch ($type) {
                    case 'corpus':
                        $objects = DB::table('corpuses')->where('directory_path',$dirArray[1])->get();
                        break;
                    case 'document':
                        $objects = DB::table('documents')->where('directory_path',$dirArray[1])->get();
                        break;
                    case 'annotation':
                        $objects = DB::table('annotations')->where('directory_path',$dirArray[1])->get();
                        break;
                }
                foreach ($objects->toArray() as $object){
                    if($object->file_name){
                        $process = new Process("rm -rf $object->file_name",$this->basePath."/".$path);
                        $process->run();
                    }
                }
            }
            else{
                $pathForDeletion = "";
                if($isProject){
                    $process = new Process("rm -rf $dirArray[0]",$this->basePath);
                    $process->run();
                }
                else if($isCorpus){
                    $pathForDeletion = $this->basePath."/".$dirArray[0];
                    $process = new Process("rm -rf *",$pathForDeletion);
                    $process->run();
                }


            }


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



    public function getListOfStagedFiles($path){
        $listOfFiles = array();
        $process = new Process("git status --porcelain | sed s/^...//",$path);
        $process->run();


        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        else{
            $processOutput = $process->getOutput();
            $listOfFiles = explode("\n", $processOutput);
        }
        return array_filter($listOfFiles);
    }

    public function checkForCorpusFiles($path){
        $result = null;
        $pythonScript = $this->scriptPath.'/src/validateHeaders.py';

        $process = new Process("python ".$pythonScript." -p ".$path);
        $process->run();


        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        else{
            $result = $process->getOutput();
        }
        return $result;
    }
}