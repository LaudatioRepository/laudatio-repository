<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 24.03.17
 * Time: 16:22
 */

namespace App\Http\Controllers;

use App\Custom\ElasticsearchInterface;
use Log;
use App\Http\Requests\SearchRequest;
use JavaScript;

class SearchController extends Controller
{
    protected $ElasticService;

    public function __construct(ElasticsearchInterface $Elasticservice)
    {
        $this->ElasticService = $Elasticservice;
    }

    public function index()
    {
        $isLoggedIn = \Auth::check();

        $publishedCorpora = $this->ElasticService->getPublishedCorpora();
        $publishedIndexes = array(
            "allCorpusIndices" => array(),
            "allDocumentIndices" => array(),
            "allAnnotationIndices" => array(),
            "indicesByCorpus" => array(),
            "allPublishedIndices" => array()
        );

        if(count($publishedCorpora['result']) > 0) {
            $document_range = "";
            foreach ($publishedCorpora['result'][0] as $publicationresponse) {
                //dd($publicationresponse);

                if (isset($publicationresponse['_source']['corpus_index'])) {

                    $current_corpus_index = $publicationresponse['_source']['corpus_index'];
                    array_push($publishedIndexes['allCorpusIndices'],$current_corpus_index);
                    array_push($publishedIndexes['allPublishedIndices'],$current_corpus_index);

                    if(!array_key_exists($current_corpus_index,$publishedIndexes['indicesByCorpus'])) {
                        $publishedIndexes['indicesByCorpus'][$current_corpus_index] = array(
                            "document_index" => "",
                            "annotation_index" => ""
                        );
                    }

                    if (isset($publicationresponse['_source']['document_index'])) {
                        $current_document_index = $publicationresponse['_source']['document_index'];
                        array_push($publishedIndexes['allDocumentIndices'],$current_document_index);
                        $publishedIndexes['indicesByCorpus'][$current_corpus_index]['document_index'] = $current_document_index;
                        array_push($publishedIndexes['allPublishedIndices'],$current_document_index);
                    }

                    if (isset($publicationresponse['_source']['annotation_index'])) {
                        $current_annotation_index = $publicationresponse['_source']['annotation_index'];
                        array_push($publishedIndexes['allAnnotationIndices'],$current_annotation_index);
                        $publishedIndexes['indicesByCorpus'][$current_corpus_index]['annotation_index'] = $current_annotation_index;
                        array_push($publishedIndexes['allPublishedIndices'],$current_annotation_index);
                    }
                }//end if isset corpusIndex
            }
        }

        JavaScript::put([
            "publishedIndexes" => $publishedIndexes,
        ]);

        return view('search.search')
            ->with('isLoggedIn', $isLoggedIn);
    }

}