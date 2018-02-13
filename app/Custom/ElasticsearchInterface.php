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
    public function getCorpus($id,$full);
    public function getDocument($id,$full);
    public function getAnnotation($id,$full);
    public function getAnnotationByName($name, $fields);
    public function getAnnotationGroups();
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
    public function getAnnotationByCorpus($searchData,$corpusData);


    public function getDocumentsByAnnotation($searchData,$annotationData);
    public function getCorporaByAnnotation($searchData,$annotationData);

    public function createIndex($name);
    public function deleteIndex($indexId);
    public function truncateIndex($index);

    /**
     * Helpers
     */

    public function checkForKey($array, $key);
    public function removeKey($array, $key);

}