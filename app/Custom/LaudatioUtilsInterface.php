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
    public function updateCorpusAttributes($params,$corpusId);
    public function corpusIsVersioned($corpusId);
    public function setDocumentAttributes($json,$corpusId,$fileName,$isDir);
    public function updateDocumentAttributes($params,$documentId);
    public function documentIsVersioned($documentId);
    public function setAnnotationAttributes($json,$corpusId,$fileName,$isDir);
    public function updateAnnotationAttributes($params,$annotationId);
    public function setPreparationAttributes($json,$annotationId,$corpusId,$isDir);
    public function annotationIsVersioned($annotationId);

    public function associateDocumentsToCorpus($documents,$corpusId);
    public function associateAnnotationsToDocument($annotations,$documentId);
    public function associateAnnotationsToCorpus($annotations,$corpusId);
    public function associatePreparationsToAnnotation($preparations,$annotationId);

    public function getModelByType($id,$type);
    public function getModelByFileName($fileName, $type, $isDir);
    public function getModelByFileAndCorpus($fileName, $type, $isDir, $corpusId);
    public function deleteModels($path);
    public function deleteModel($type,$id);
    public function updateDirectoryPaths($directory_path,$corpusId);
    public function setVersionMapping($filename, $type,$isDir);

    public function getDirectoryPath($paths,$fileName);
}