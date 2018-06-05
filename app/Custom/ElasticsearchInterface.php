<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 06.07.17
 * Time: 17:12
 */
namespace App\Custom;
use Illuminate\Http\Request;

interface ElasticsearchInterface {
    public function getPublishedCorpora();
    public function getCorpus($id,$full);
    public function deleteCorpus($id);
    public function getDocument($id,$full);
    public function deleteDocument($id,$corpusId);
    public function getAnnotation($id,$full);
    public function deleteAnnotation($title,$corpusId);
    public function getAnnotationByName($name, $fields);
    public function getAnnotationByNameAndCorpusId($name, $corpusId, $fields);
    public function getAnnotationGroups();
    public function getGuidelinesByCorpus($corpusId);
    public function getGuidelinesByCorpusAndAnnotationId($corpusId,$annotationName);
    public function getFormatsByCorpus($corpusId);
    public function search($index, $field, $term);
    public function searchGeneral($searchData);
    public function searchCorpusIndex($searchData);
    public function rangeSearch($searchData);
    public function searchDocumentIndex($searchData);
    public function searchDocumentIndexWithParam(Request $request);
    public function getSearchTotal($searchData,$index);
    public function searchAnnotationIndex($searchData);
    public function getCorpusByDocument($searchData,$documentData);
    public function getAnnotationByDocument($searchData,$documentData);
    public function getCorpusTitlesByDocument($searchData,$documentData);
    public function getCorpusByAnnotation($searchData);
    public function getDocumentByCorpus($searchData,$corpusData);
    public function getDocumentsByAnnotationAndCorpusId($documentList,$corpusId);
    public function getDocumentsByDocumentId($documentids);
    public function getAnnotationByCorpus($searchData,$corpusData,$fields);


    public function getDocumentsByAnnotation($searchData,$annotationData);
    public function getCorporaByAnnotation($searchData,$annotationData);

    public function createIndex($name);
    public function deleteIndex($indexId);
    public function truncateIndex($index);
    public function deleteIndexedObject($index,$params);
    public function getElasticIdByObjectId($index,$params);

    /**
     * Helpers
     */

    public function checkForKey($array, $key);
    public function removeKey($array, $key);

}