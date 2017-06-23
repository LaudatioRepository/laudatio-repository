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
use Vinkla\GitLab\Facades\GitLab;

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
        print "<br><br>ADDING: ".$path;
        $process = new Process("git add .",$path);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    public function doAddFile($path,$file){
        print "<br><br>ADDING: ".$path;
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

    public function isCommitted2($status){
        return (strpos($status,"file changed,") !== false);
    }

    public function isCommitted($commitmessage, $logmessage){
        print "<br><br>CHECKING LOG:  ".$logmessage." COMMIT: ".$commitmessage;
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
                $addResult = $this->doAdd($this->basePath."/".$pathWithOutAddedFolder."/".$folder);
                $addStatus = $this->getStatus($this->basePath."/".$pathWithOutAddedFolder);
                if($this->isAdded($addStatus)){
                    $isAdded = true;
                }
            }
        }

        return $isAdded;
    }

    public function commitFiles($path, $commitmessage){
        $isCommitted = false;
        $process = new Process("git commit -m \"".$commitmessage."\" ",$path);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        else{
            $processOutput = $process->getOutput();
            print "<br>    <br>PRINCESSOUTPUT: ".$processOutput;
            $logMessage = $this->getLogMessage("1",$this->basePath."/".$path);
            print "<br><br>GOT LOG: ".$logMessage;
            if($this->isCommitted($commitmessage,$processOutput)){
                $isCommitted = true;
                //$status = $this->getStatus($this->basePath."/".$path);
                print "<br><br>PRINCESSSTATUS: ".$logMessage;
            }
        }

        return $isCommitted;
    }

    public function addFileUpdate($path, $file){
        $isAdded = false;

        if($this->fileHasDiff($this->basePath."/".$path,$file)){
            $addResult = $this->doAddFile($this->basePath."/".$path,$file);
            $addStatus = $this->getStatus($this->basePath."/".$path);
            if($this->isAdded($addStatus)){
                $isAdded = true;
            }
        }

        return $isAdded;
    }

    public function deleteFiles($path){

        $isdeleted = false;
        $isFile = false;
        $pathWithOutAddedFolder = "";
        $folder = "";
        $cwdPath = "";

        $dotpos = strrpos($path,".");
        if($dotpos !== false && $dotpos == strlen($path)-4){
            print "<br><br />>ISFILE: ".$path;
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
        print "<br><br />trackstatus: ".$trackstatus;
        $process = null;
        $folder = str_replace(" ","\\ ",$folder);
        print "<br>THE FOLDER: ".$folder;
        if($this->isUntracked($trackstatus)){
            $process = new Process("rm -rf $folder",$cwdPath);
            $process->run();

        }
        else{
            $process = new Process("rm -rf $folder",$cwdPath);
            $process->run();

        }

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        else{
            print "<br><br />>PROCESSWORKD: ".$cwdPath."/-".$folder;
            if($isFile){
                $this->doAdd($cwdPath);
            }
            else{
                $this->doAdd($cwdPath."/".$folder);
            }

            $addStatus = $this->getStatus($cwdPath);
            print "<br><br />>ADDSTATUS: ".$addStatus;
            if($this->isAdded($addStatus)){
                print "<br><br />>WASADDED: ".$addStatus;
                $commit = $this->commitFiles($cwdPath,"deleting $cwdPath/$folder");
                $commitstatus = $this->getStatus($cwdPath);
                print "<br><br>NOCH SCHTATUZZ: ".$commitstatus;
                if($this->isCleanWorkingTree($commitstatus)){
                    print "<br><br>ISCLEAN: ";
                    $isdeleted = true;
                }
            }
        }

        return $isdeleted;
    }
}