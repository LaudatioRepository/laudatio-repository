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
    public function updateCorpusFileAttributes($corpus);
    public function duplicateCorpus($oldCorpus, $new_corpus_elasticsearch_id, $new_corpus_id,$new_corpus_index, $new_guideline_index, $now,$oldDocumentIndex,$oldAnnotationIndex, $new_document_index,$new_annotation_index);
    public function corpusIsVersioned($corpusId);
    public function setDocumentAttributes($json,$corpusId,$uid,$fileName,$isDir);
    public function updateDocumentAttributes($params,$documentId);
    public function documentIsVersioned($documentId);
    public function setAnnotationAttributes($json,$corpusId,$uid,$fileName,$isDir);
    public function updateAnnotationAttributes($params,$annotationId);
    public function setPreparationAttributes($json,$annotationId,$corpusId,$isDir);
    public function annotationIsVersioned($annotationId);

    public function associateDocumentsToCorpus($documents,$corpusId);
    public function associateAnnotationsToDocument($annotations,$documentId);
    public function associateAnnotationsToCorpus($annotations,$corpusId);
    public function associatePreparationsToAnnotation($preparations,$annotationId);

    public function getModelByType($id,$type);
    public function getModelByFileName($fileName, $type, $isDir, $corpusId);
    public function getModelByFileAndCorpus($fileName, $type, $isDir, $corpusId);
    public function getElasticSearchIdByCorpusId($corpusid,$corpus_index);
    public function getElasticSearchIndexByCorpusId($corpusid);
    public function getDatabaseIdByCorpusId($corpusid);
    public function getDocumentGenreByCorpusId($corpusid,$index);
    public function getCorpusPathByCorpusId($corpusid,$corpus_index);
    public function deleteModels($path);
    public function deleteModel($type,$id);
    public function updateDirectoryPaths($directory_path,$corpusId);
    public function setVersionMapping_old($filename, $type,$isDir,$corpusid);
    public function setVersionMapping($object, $type);
    public function setCommitData($commitData,$corpusId);

    public function getDirectoryPath($paths,$fileName);
    public function getCorpusVersion($corpusId);
    public function getWorkFlowStatus($corpusId);

    public function buildCiteFormat($data);
    public function getLicenseByCorpus($data);

    public function getCurrentCorpusIndexByElasticsearchId($elasticSearchId);
    public function getCurrentDocumentIndexByElasticsearchId($elasticSearchId);
    public function getCurrentAnnotationIndexByElasticsearchId($elasticSearchId);

    public function getCurrentCorpusIndexByAnnotationElasticsearchId($elasticSearchId);
    public function getCurrentCorpusIndexByDocumentElasticsearchId($elasticSearchId);

    public function getPublishedCorpusData($corpusresponses,$elasticService, $perPage ,$sortKriterium, $currentPage);


    /* CACHE */
    public function emptyCorpusCache($corpusId,$index);

    public function emptyDocumentCacheByCorpusId($corpusId,$index);
    public function emptyDocumentCacheByDocumentIndex($documentIndex);

    public function emptyAnnotationCacheByCorpusId($corpusId,$index);
    public function emptyAnnotationCacheByAnnotationIndex($index);
    public function emptyAnnotationGroupCacheByAnnotationAndCorpusId($annotationId,$corpusId, $index);
}
