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
        $data = $this->ElasticService->getDocument($header,$header,$id);

        JavaScript::put([
            "header" => $header,
            "header_id" => $id,
            "header_data" => $data
        ]);
        return view('browse.showHeaders');
    }

}
