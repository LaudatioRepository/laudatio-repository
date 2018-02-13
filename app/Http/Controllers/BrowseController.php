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

                $annotationGroups = $this->ElasticService->getAnnotationGroups();
                $data['result']['annotationGroups'] = $annotationGroups['aggregations']['annotations']['buckets'];
                break;
            case "annotation":
                $data = $this->ElasticService->getAnnotation($id);
                break;
        }
        //dd($data);
        dd($data);
        JavaScript::put([
            "header" => $header,
            "header_id" => $id,
            "header_data" => $data
        ]);
        return view('browse.showHeaders');
    }

}
