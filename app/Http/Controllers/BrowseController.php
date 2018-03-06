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
                break;
            case "document":
                $data = $this->ElasticService->getDocument($id);

                if(count($data['result']['in_corpora']) > 0){
                    $documentCorpusdata = $this->ElasticService->getCorpusByDocument(array(array('corpus_id' => $data['result']['in_corpora'][0])),array($id));
                    $data['result']['documentCorpusdata'] = $documentCorpusdata[$id][0]['_source'];
                }

                $annotationMapping = array();
                foreach($data['result']['document_list_of_annotations_id'] as $annotationId){
                    $annotationData = $this->ElasticService->getAnnotationByName($annotationId, array(
                        "preparation_encoding_annotation_group",
                        "preparation_title",
                        "in_documents"
                    ));


                    if(!$annotationData['error'] && count($annotationData['result']) > 0){
                        if(array_key_exists('preparation_encoding_annotation_group', $annotationData['result'][0])){
                            $groups = array_unique($annotationData['result'][0]['preparation_encoding_annotation_group']);
                            foreach ($groups as $group){
                                if(!array_key_exists($group,$annotationMapping)){
                                    $annotationMapping[$group] = array();
                                }
                                $dataArray = array();
                                if(array_key_exists('in_documents', $annotationData['result'][0])){
                                    $dataArray['document_count'] = floatval(count($annotationData['result'][0]['in_documents']));
                                }
                                $dataArray['title'] = $annotationData['result'][0]['preparation_title'][0];
                                array_push($annotationMapping[$group],$dataArray);
                            }
                        }
                    }

                }


                $data['result']['annotationGroups'] = $annotationMapping;

                break;
            case "annotation":
                $data = $this->ElasticService->getAnnotation($id);
                if(count($data['result']['in_corpora']) > 0){
                    //$annotationCorpusdata = $this->ElasticService->getCorporaByAnnotation(array(array('corpus_id' => $data['result']['in_corpora'])),array($id));
                    $annotationCorpusdata = $this->ElasticService->getCorporaByAnnotation(array(array('corpus_id' => $data['result']['in_corpora'][0])),array($id));
                    $data['result']['annotationCorpusdata'] = $annotationCorpusdata[$id][0]['_source'];
                }
                $guidelines = $this->ElasticService->getGuidelinesByCorpusAndAnnotationId($data['result']['in_corpora'][0],$data['result']['preparation_annotation_id'][0]);

                $formats = array();
                $formatSearchResult = $this->ElasticService->getFormatsByCorpus($data['result']['in_corpora'][0]);
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
                $data['result']['allformats'] = $formats;

                $data['result']['guidelines'] = $guidelineArray;
                //Log::info("GUIDELINES: ".print_r( $data['result']['guidelines'],1 ));
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
