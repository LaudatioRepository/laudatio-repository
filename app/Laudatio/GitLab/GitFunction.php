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
        print "<br>THE FOLDER: ".$folder." cwdPath: $cwdPath";

        $process = new Process("rm -rf $folder",$cwdPath);
        $process->run();

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

    /**
     * Converts to ASCII.
     * @param  string  UTF-8 encoding
     * @return string  ASCII
     */
    public function normalizeFileName($s) {
        static $transliterator = NULL;
        if ($transliterator === NULL && class_exists('Transliterator', FALSE)) {
            $transliterator = \Transliterator::create('Any-Latin; Latin-ASCII');
        }

        $s = preg_replace('#[^\x09\x0A\x0D\x20-\x7E\xA0-\x{2FF}\x{370}-\x{10FFFF}]#u', '', $s);
        $s = strtr($s, '`\'"^~?', "\x01\x02\x03\x04\x05\x06");
        $s = str_replace(
            array("\xE2\x80\x9E", "\xE2\x80\x9C", "\xE2\x80\x9D", "\xE2\x80\x9A", "\xE2\x80\x98", "\xE2\x80\x99", "\xC2\xB0"),
            array("\x03", "\x03", "\x03", "\x02", "\x02", "\x02", "\x04"), $s
        );
        if ($transliterator !== NULL) {
            $s = $transliterator->transliterate($s);
        }
        if (ICONV_IMPL === 'glibc') {
            $s = str_replace(
                array("\xC2\xBB", "\xC2\xAB", "\xE2\x80\xA6", "\xE2\x84\xA2", "\xC2\xA9", "\xC2\xAE"),
                array('>>', '<<', '...', 'TM', '(c)', '(R)'), $s
            );
            $s = @iconv('UTF-8', 'WINDOWS-1250//TRANSLIT//IGNORE', $s); // intentionally @
            $s = strtr($s, "\xa5\xa3\xbc\x8c\xa7\x8a\xaa\x8d\x8f\x8e\xaf\xb9\xb3\xbe\x9c\x9a\xba\x9d\x9f\x9e"
                . "\xbf\xc0\xc1\xc2\xc3\xc4\xc5\xc6\xc7\xc8\xc9\xca\xcb\xcc\xcd\xce\xcf\xd0\xd1\xd2\xd3"
                . "\xd4\xd5\xd6\xd7\xd8\xd9\xda\xdb\xdc\xdd\xde\xdf\xe0\xe1\xe2\xe3\xe4\xe5\xe6\xe7\xe8"
                . "\xe9\xea\xeb\xec\xed\xee\xef\xf0\xf1\xf2\xf3\xf4\xf5\xf6\xf8\xf9\xfa\xfb\xfc\xfd\xfe"
                . "\x96\xa0\x8b\x97\x9b\xa6\xad\xb7",
                'ALLSSSSTZZZallssstzzzRAAAALCCCEEEEIIDDNNOOOOxRUUUUYTsraaaalccceeeeiiddnnooooruuuuyt- <->|-.');
            $s = preg_replace('#[^\x00-\x7F]++#', '', $s);
        } else {
            $s = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $s); // intentionally @
        }
        $s = str_replace(array('`', "'", '"', '^', '~', '?'), '', $s);
        return strtr($s, "\x01\x02\x03\x04\x05\x06", '`\'"^~?');
    }

    /**
     * Converts to web safe characters [a-z0-9-] text.
     * @param  string  UTF-8 encoding
     * @param  string  allowed characters
     * @param  bool
     * @return string
     */
    public function webalize($s, $charlist = NULL, $lower = TRUE)
    {
        $s = self::toAscii($s);
        if ($lower) {
            $s = strtolower($s);
        }
        $s = preg_replace('#[^a-z0-9' . preg_quote($charlist, '#') . ']+#i', '-', $s);
        $s = trim($s, '-');
        return $s;
    }

}