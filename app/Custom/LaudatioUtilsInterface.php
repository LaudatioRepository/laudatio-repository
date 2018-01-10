<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 06.12.17
 * Time: 10:04
 */

namespace App\Custom;


interface LaudatioUtilsInterface
{
    public function parseXMLToJson($xml, $options);

    public function setCorpusAttributes($json,$params);
    public function setDocumentAttributes($json,$corpusId,$fileName,$isDir);
    public function setAnnotationAttributes($json,$corpusId,$fileName,$isDir);
    public function setPreparationAttributes($json,$annotationId,$corpusId,$isDir);

    public function associateDocumentsToCorpus($documents,$corpusId);
    public function associateAnnotationsToDocument($annotations,$documentId);
    public function associateAnnotationsToCorpus($annotations,$corpusId);
    public function associatePreparationsToAnnotation($preparations,$annotationId);

    public function getModelByType($id,$type);
    public function getModelByFileName($fileName, $type, $isDir);
    public function setVersionMapping($filename, $type,$isDir);
    public function getDirectoryPath($paths,$fileName);
}