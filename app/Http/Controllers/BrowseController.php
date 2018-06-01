<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Custom\ElasticsearchInterface;
use App\Custom\LaudatioUtilsInterface;
use JavaScript;
use Log;

class BrowseController extends Controller
{

    protected $ElasticService;
    protected $LaudatioUtilService;

    public function __construct(ElasticsearchInterface $Elasticservice, LaudatioUtilsInterface $laudatioUtils)
    {
        $this->ElasticService = $Elasticservice;
        $this->LaudatioUtilService = $laudatioUtils;
    }

    public function index(){
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        $corpusresponses = $this->ElasticService->getPublishedCorpora();


        $corpusdata = array();
        $documentcount = 0;
        $annotationcount = 0;
        foreach($corpusresponses['result'] as $corpusresponse){
           //dd($corpusresponse);
            $documentResult = $this->ElasticService->getDocumentByCorpus(
                array(array("in_corpora" => $corpusresponse['_source']['corpus_id'][0])),
                array($corpusresponse['_source']['corpus_id'][0])
            );
            if(isset($documentResult[$corpusresponse['_source']['corpus_id'][0]])) {
                $documentcount = count($documentResult[$corpusresponse['_source']['corpus_id'][0]]);
            }

            $annotationResult = $this->ElasticService->getAnnotationByCorpus(
                array(array("in_corpora" => $corpusresponse['_source']['corpus_id'][0])),
                array($corpusresponse['_source']['corpus_id'][0])
            );

            if(isset($annotationResult[$corpusresponse['_source']['corpus_id'][0]])){
                $annotationcount = count($annotationResult[$corpusresponse['_source']['corpus_id'][0]]);
            }


            if(!array_key_exists($corpusresponse['_source']['corpus_id'][0],$corpusdata)){

                $authors = "";
                for($i = 0; $i < count($corpusresponse['_source']['corpus_editor_forename']); $i++){
                    $authors .= $corpusresponse['_source']['corpus_editor_surname'][$i].", ".$corpusresponse['_source']['corpus_editor_forename'][$i].";";
                }

                $corpusdata[$corpusresponse['_source']['corpus_id'][0]] = array(
                    'corpus_title' => $corpusresponse['_source']['corpus_title'][0],
                    'authors' => $authors,
                    'corpus_languages_language' => $corpusresponse['_source']['corpus_languages_language'][0],
                    'corpus_size_value' => $corpusresponse['_source']['corpus_size_value'][0],
                    'corpus_encoding_project_description' => $corpusresponse['_source']['corpus_encoding_project_description'][0],
                    'documentcount' => $documentcount,
                    'annotationcount' => $annotationcount,
                    'elasticid' => $corpusresponse['_id']
                );
            }

        }

       // dd($corpusdata);
        return view('browse.index')
            ->with('isLoggedIn', $isLoggedIn)
            ->with('corpusdata',$corpusdata)
            ->with('user',$user);
    }

    /**
     * @param $header
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($header,$id){
        $data = null;
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        $corpusElasticId = null;
        switch ($header){
            case "corpus":
                $apiData = $this->ElasticService->getCorpus($id);
                $data = json_decode($apiData->getContent(), true);

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
                $apiData = $this->ElasticService->getDocument($id);
                $data = json_decode($apiData->getContent(), true);

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
                $apiData = $this->ElasticService->getAnnotation($id);
                $data = json_decode($apiData->getContent(), true);
                $corpusId = is_array($data['result']['in_corpora']) ? $data['result']['in_corpora'][0]: $data['result']['in_corpora'];
                if($corpusId){

                    $annotationCorpusdata = $this->ElasticService->getCorporaByAnnotation(array(array('corpus_id' => $corpusId)),array($id));
                    $data['result']['annotationCorpusdata'] = $annotationCorpusdata[$id][0]['_source'];
                    $guidelines = $this->ElasticService->getGuidelinesByCorpusAndAnnotationId($corpusId,$data['result']['preparation_annotation_id'][0]);
                    //dd($guidelines);
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
                        //dd($documentsByAnnotation);
                        $data['result']['documents'] = $documentsByAnnotation['results'];
                        $data['result']['annotationdocumentcount'] = count($documentsByAnnotation['results']);
                    }


                    $data['result']['allformats'] = $formats;
                    $data['result']['guidelines'] = $guidelineArray;
                    //dd($data);
                    //Log::info("GUIDELINES: ".print_r( $data['result']['guidelines'],1 ));
                }
                break;
        }
        //dd($isLoggedIn);

        JavaScript::put([
            "header" => $header,
            "header_id" => $id,
            "corpus_elasticsearch_id" => $this->LaudatioUtilService->getElasticSearchIdByCorpusId($corpusId),
            "corpus_id" => $this->LaudatioUtilService->getDatabaseIdByCorpusId($corpusId),
            "corpus_path" => $this->LaudatioUtilService->getCorpusPathByCorpusId($corpusId),
            "header_data" => $data,
            "user" => $user,
            "isLoggedIn" => $isLoggedIn
        ]);
        return view('browse.showHeaders')
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

}
