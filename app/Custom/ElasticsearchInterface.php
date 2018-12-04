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
    public function setCorpusToPublished($params);
    public function getCorpus($id,$full,$index);
    public function deleteCorpus($id);
    public function deleteIndexedObject($index,$params);
    public function getDocument($id,$full,$index);
    public function getAnnotation($id,$full,$index);
    public function getAnnotationByName($name, $fields);
    public function getAnnotationByNameAndCorpusId($name, $corpusId, $fields,$index);
    public function getAnnotationGroups($matchdata,$index);
    public function getGuidelinesByCorpus($corpusId,$index);
    public function getGuidelinesByCorpusAndAnnotationId($corpusId,$annotationName,$index);
    public function getFormatsByCorpus($corpusId,$index);
    public function search($index, $field, $term);
    public function searchGeneral($searchData);
    public function listAllPublished($searchData);
    public function searchCorpusIndex($searchData);
    public function rangeSearch($searchData);
    public function searchDocumentIndex($searchData);
    public function searchDocumentIndexWithParam(Request $request);
    public function getSearchTotal($searchData,$index);
    public function searchAnnotationIndex($searchData);
    public function getCorpusByDocument($searchData,$documentData,$index);
    public function getAnnotationByDocument($searchData,$documentData);
    public function getCorpusTitlesByDocument($searchData,$documentData);
    public function getCorpusByAnnotation($searchData);
    public function getDocumentByCorpus($searchData,$corpusData,$fields,$index);
    public function getDocumentsByAnnotationAndCorpusId($documentList,$corpusId,$index);
    public function getDocumentsByDocumentId($documentids,$index);
    public function getAnnotationByCorpus($searchData,$corpusData,$fields,$index);
    public function getAnnotationsByCorpusId($corpusId,$index,$fields);


    public function getDocumentsByAnnotation($searchData,$annotationData);
    public function getCorporaByAnnotation($searchData,$annotationData,$index);

    public function createIndex($params);
    public function reIndex($params);
    public function createMappedIndex($indexMappingPath, $index_id);
    public function createMappedIndexAndReindex($indexMappingPath, $new_index_id, $old_index_id,$matchQuery,$new_elasticsearch_id,$new_corpus_id);
    public function deleteIndex($indexId);
    public function truncateIndex($index);
    public function postToIndex($params);
    public function updateDocumentFieldsInAnnotation($new_annotation_index,$annotation_ids);
    public function setMapping($params);
    public function getElasticIdByObjectId($index,$params);
    public function setWorkflowStatusByCorpusId($corpus_id);

    /**
     * Helpers
     */

    public function checkForKey($array, $key);
    public function removeKey($array, $key);

}