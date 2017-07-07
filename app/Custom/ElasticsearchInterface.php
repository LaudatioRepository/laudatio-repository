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
    public function getSearchTotal($searchData);
    public function searchAnnotationIndex($searchData);

}