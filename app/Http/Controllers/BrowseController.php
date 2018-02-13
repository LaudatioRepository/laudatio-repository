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
                    $documentCorpusdata = $this->ElasticService->getCorpusByDocument(array(array('_id' => $data['result']['in_corpora'][0])),array($id));
                    $data['result']['documentCorpusdata'] = $documentCorpusdata[$id][0]['_source'];
                }

                $annotationMapping = array();
                foreach($data['result']['document_list_of_annotations_id'] as $annotationId){
                    $annotationData = $this->ElasticService->getAnnotationByName($annotationId, array(
                        "preparation_encoding_annotation_group",
                        "preparation_title",
                        "in_documents"
                    ));

                    //Log::info("group: ".print_r($annotationData['result'],1));
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
