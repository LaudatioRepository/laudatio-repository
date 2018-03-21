<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Custom\ElasticsearchInterface;
use JavaScript;
use Log;

class BrowseController extends Controller
{

    protected $ElasticService;

    public function __construct(ElasticsearchInterface $Elasticservice)
    {
        $this->ElasticService = $Elasticservice;
    }

    /**
     * @param $header
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($header,$id){
        $data = null;
        switch ($header){
            case "corpus":
                $data = $this->ElasticService->getCorpus($id);

                $corpusId = is_array($data['result']['corpus_id']) ? $data['result']['corpus_id'][0]: $data['result']['corpus_id'];
                $formatSearchResult = $this->ElasticService->getFormatsByCorpus($corpusId);
                $formats = array();
                foreach ($formatSearchResult['aggregations']['formats']['buckets'] as $formatSearchResult) {
                    array_push($formats,$formatSearchResult['key']);
                }
                $data['result']['formats'] = $formats;

                $documentResult = $this->ElasticService->getDocumentByCorpus(
                    array(array("in_corpora" => $corpusId)),
                    array($corpusId)
                );

                $allDocumentsResult = $this->ElasticService->getDocumentsByDocumentId($data['result']['corpus_documents']);
               //dd($data['result']['corpus_documents']);
                $corpusDocuments = array();

                $documentcount = 0;
                foreach ($documentResult as $cid => $cdata) {
                    foreach ($cdata as $citem) {
                        $documentArray = array();
                        $documentArray['document_id'] = $citem['_id'];
                        $documentArray["document_title"] = $citem['_source']["document_title"];
                        $documentArray["document_publication_publishing_date"] = $citem['_source']["document_publication_publishing_date"];
                        $documentArray["document_publication_place"] = $citem['_source']["document_publication_place"];
                        $documentArray["document_list_of_annotations_name"] = $citem['_source']["document_list_of_annotations_name"];
                        $documentArray["document_size_extent"] = $citem['_source']["document_size_extent"];
                        array_push($corpusDocuments, $documentArray);
                        $documentcount++;
                    }
                }
                $data['result']['corpusdocuments'] = $corpusDocuments;
                $data['result']['corpusdocumentcount'] = $documentcount;



                $annotationMapping = array();
                $annotationcount = 0;
                $totalannotationcount = count($data['result']['annotation_id']);
                foreach($data['result']['annotation_id'] as $annotationId){
                    $annotationData = $this->ElasticService->getAnnotationByName($annotationId, array(
                        "preparation_encoding_annotation_group",
                        "preparation_title",
                        "_id",
                        "in_documents"
                    ));

                    if(!$annotationData['error'] && count($annotationData['result']) > 0){
                        $foundAnnotation = array();
                        if(array_key_exists('preparation_encoding_annotation_group', $annotationData['result'][0]['_source'])){
                            $groups = array_unique($annotationData['result'][0]['_source']['preparation_encoding_annotation_group']);
                            foreach ($groups as $group){
                                if(!array_key_exists($group,$annotationMapping)){
                                    $annotationMapping[$group] = array();
                                }
                                $dataArray = array();
                                if(array_key_exists('in_documents', $annotationData['result'][0]['_source'])){
                                    $dataArray['document_count'] = floatval(count($annotationData['result'][0]['_source']['in_documents']));
                                }
                                $dataArray['title'] = $annotationData['result'][0]['_source']['preparation_title'][0];
                                $dataArray['preparation_annotation_id'] = $annotationData['result'][0]['_id'];
                                array_push($annotationMapping[$group],$dataArray);
                            }
                            if(!in_array($annotationData['result'][0]['_id'],$foundAnnotation)){
                                $annotationcount++;
                            }
                        }
                    }

                }

                $allAnnotationGroupResult = $this->ElasticService->getAnnotationGroups();
                $allAnnotationGroups = array();
                foreach($allAnnotationGroupResult['aggregations']['annotations']['buckets'] as $groupdata) {
                    array_push($allAnnotationGroups,$groupdata['key']);
                }


                $data['result']['corpusAnnotationGroups'] = $annotationMapping;
                $data['result']['allAnnotationGroups'] = $allAnnotationGroups;
                $data['result']['corpusannotationcount'] = $annotationcount;
                $data['result']['totalcorpusannotationcount'] = $totalannotationcount;


                break;
            case "document":
                $data = $this->ElasticService->getDocument($id);
                $corpusId = is_array($data['result']['in_corpora']) ? $data['result']['in_corpora'][0]: $data['result']['in_corpora'];
                if($corpusId){
                    $documentCorpusdata = $this->ElasticService->getCorpusByDocument(array(array('corpus_id' => $corpusId)),array($id));
                    $data['result']['documentCorpusdata'] = $documentCorpusdata[$id][0]['_source'];

                    $annotationMapping = array();
                    $documentannotationcount = 0;
                    $totalannotationcount = count($data['result']['document_list_of_annotations_id']);
                    foreach($data['result']['document_list_of_annotations_id'] as $annotationId){
                        $annotationData = $this->ElasticService->getAnnotationByName($annotationId, array(
                            "preparation_encoding_annotation_group",
                            "preparation_title",
                            "_id",
                            "in_documents"
                        ));


                        if(!$annotationData['error'] && count($annotationData['result']) > 0){
                            $foundAnnotation = array();
                            if(array_key_exists('preparation_encoding_annotation_group', $annotationData['result'][0]['_source'])){
                                $groups = array_unique($annotationData['result'][0]['_source']['preparation_encoding_annotation_group']);
                                foreach ($groups as $group){
                                    if(!array_key_exists($group,$annotationMapping)){
                                        $annotationMapping[$group] = array();
                                    }
                                    $dataArray = array();
                                    if(array_key_exists('in_documents', $annotationData['result'][0]['_source'])){
                                        $dataArray['document_count'] = floatval(count($annotationData['result'][0]['_source']['in_documents']));
                                    }
                                    $dataArray['title'] = $annotationData['result'][0]['_source']['preparation_title'][0];
                                    $dataArray['preparation_annotation_id'] = $annotationData['result'][0]['_id'];
                                    array_push($annotationMapping[$group],$dataArray);
                                }
                                if(!in_array($annotationData['result'][0]['_id'],$foundAnnotation)){
                                    $documentannotationcount++;
                                }
                            }
                        }

                    }

                    $allAnnotationGroupResult = $this->ElasticService->getAnnotationGroups();
                    $allAnnotationGroups = array();
                    foreach($allAnnotationGroupResult['aggregations']['annotations']['buckets'] as $groupdata) {
                        array_push($allAnnotationGroups,$groupdata['key']);
                    }

                    $data['result']['allAnnotationGroups'] = $allAnnotationGroups;
                    $data['result']['documentannotationcount'] = $documentannotationcount;
                    $data['result']['annotationGroups'] = $annotationMapping;
                    $data['result']['totaldocumentannotationcount'] = $totalannotationcount;
                }

                break;
            case "annotation":
                $data = $this->ElasticService->getAnnotation($id);
                $corpusId = is_array($data['result']['in_corpora']) ? $data['result']['in_corpora'][0]: $data['result']['in_corpora'];
                if($corpusId){

                    $annotationCorpusdata = $this->ElasticService->getCorporaByAnnotation(array(array('corpus_id' => $corpusId)),array($id));
                    $data['result']['annotationCorpusdata'] = $annotationCorpusdata[$id][0]['_source'];
                    $guidelines = $this->ElasticService->getGuidelinesByCorpusAndAnnotationId($corpusId,$data['result']['preparation_annotation_id'][0]);
                    $formats = array();
                    $formatSearchResult = $this->ElasticService->getFormatsByCorpus($corpusId);

                    $guidelineArray = array();
                    foreach ($formatSearchResult['aggregations']['formats']['buckets'] as $formatSearchResult) {

                        if(!array_key_exists($formatSearchResult['key'],$guidelineArray)){
                            $guidelineArray[$formatSearchResult['key']] = array('annotations' => array());
                        }

                        foreach ($guidelines['result']['hits']['hits'] as $guideline){
                            foreach ($guideline['_source']['in_annotations'] as $annotationkey) {
                                if($data['result']['preparation_annotation_id'][0] == $annotationkey &&
                                    in_array($formatSearchResult['key'],$guideline['_source']['formats'])){
                                    if(!array_key_exists($annotationkey, $guidelineArray[$formatSearchResult['key']]['annotations'])){
                                        $guidelineArray[$formatSearchResult['key']]['annotations'][$annotationkey] = array();
                                    }

                                    if(!array_key_exists($guideline['_source']['id'], $guidelineArray[$formatSearchResult['key']]['annotations'][$annotationkey])){
                                        $guidelineArray[$formatSearchResult['key']]['annotations'][$annotationkey][$guideline['_source']['id']] = $guideline['_source']['desc'];
                                    }
                                }

                            }

                        }

                        array_push($formats,$formatSearchResult['key']);

                    }

                    if(count($data['result']['in_documents']) > 0){
                        $documentsByAnnotation = $this->ElasticService->getDocumentsByAnnotationAndCorpusId($data['result']['in_documents'],$corpusId);
                        $data['result']['documents'] = $documentsByAnnotation['results'];
                        $data['result']['annotationdocumentcount'] = count($documentsByAnnotation['results']);
                    }


                    $data['result']['allformats'] = $formats;
                    $data['result']['guidelines'] = $guidelineArray;
                    //Log::info("GUIDELINES: ".print_r( $data['result']['guidelines'],1 ));
                }
                break;
        }
        //dd($data);

        JavaScript::put([
            "header" => $header,
            "header_id" => $id,
            "header_data" => $data
        ]);
        return view('browse.showHeaders');
    }

}
