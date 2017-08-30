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
    public function getDocument($index,$type,$id);
    public function search($index, $field, $term);
    public function searchGeneral($searchData);
    public function searchCorpusIndex($searchData);
    public function searchDocumentIndex($searchData);
    public function searchDocumentIndexWithParam(Request $request);
    public function getSearchTotal($searchData,$index);
    public function searchAnnotationIndex($searchData);
    public function getCorpusByDocument($searchData,$documentData);
    public function getAnnotationByDocument($searchData,$documentData);
    public function getCorpusTitlesByDocument($searchData,$documentData);
    public function getCorpusByAnnotation($searchData);
    public function getDocumentByCorpus($corpus_ids);
    public function getAnnotationByCorpus($corpus_ids);


    public function getDocumentsByAnnotation($searchData);
    public function createIndex($name);
    public function deleteIndex($indexId);
    public function truncateIndex($index);
}