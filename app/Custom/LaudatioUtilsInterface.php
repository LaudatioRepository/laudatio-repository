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

    public function setCorpusAttributes($json,$corpusId);
    public function setDocumentAttributes($json,$corpusId);
    public function setAnnotationAttributes($json,$corpusId);
    public function setPreparationAttributes($json,$annotationId,$corpusId);

    public function associateDocumentsToCorpus($documents,$corpusId);
    public function associateAnnotationsToDocument($annotations,$documentId);
    public function associateAnnotationsToCorpus($annotations,$corpusId);
    public function associatePreparationsToAnnotation($preparations,$annotationId);
}