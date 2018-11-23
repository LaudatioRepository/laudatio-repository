<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 24.03.17
 * Time: 16:22
 */

namespace App\Http\Controllers;

use App\Custom\ElasticsearchInterface;
use App\Custom\LaudatioUtilsInterface;
use Illuminate\Http\Request;
use Log;
use App\Http\Requests\SearchRequest;
use JavaScript;

class SearchController extends Controller
{
    protected $ElasticService;
    protected $LaudatioUtils;

    public function __construct(ElasticsearchInterface $Elasticservice,LaudatioUtilsInterface $laudatioUtils)
    {
        $this->ElasticService = $Elasticservice;
        $this->LaudatioUtils = $laudatioUtils;
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

    public function frontPageSearch(Request $request) {

        $validated = $this->validate($request,[
            'search_terms' => 'required|string|max:255',
        ]);


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



        $searchData = array(
            "fields" => array(
                "corpus_title",
                "corpus_editor_forename",
                "corpus_editor_surname",
                "corpus_publication_publisher",
                "corpus_documents",
                "corpus_merged_formats",
                "corpus_encoding_tool",
                "corpus_encoding_project_description",
                "corpus_annotator_forename",
                "corpus_annotator_surname",
                "corpus_publication_license",
                "corpus_languages_language",
                "corpus_languages_iso_code",
                //"corpus_publication_publication_date",
                "document_title",
                "document_author_forename",
                "document_size_type",
                "document_size_extent",
                "document_author_surname",
                "document_editor_forename",
                "document_editor_surname",
                "document_languages_language",
                "document_languages_iso_code",
                "document_publication_place",
                "document_merged_authors",
                //"document_publication_publishing_date",
                "preparation_title",
                "preparation_annotation_id",
                "preparation_encoding_annotation_group",
                "preparation_encoding_annotation_sub_group",
                "preparation_encoding_full_name",
                "annotation_merged_formats"
            ),
            "source" => array(
                "corpus_title",
                "corpus_id",
                "corpus_editor_forename",
                "corpus_editor_surname",
                "corpus_publication_publisher",
                "corpus_documents",
                "corpus_merged_formats",
                "corpus_encoding_tool",
                "corpus_encoding_project_description",
                "corpus_annotator_forename",
                "corpus_annotator_surname",
                "corpus_publication_license",
                "corpus_languages_language",
                "corpus_languages_iso_code",
                "corpus_publication_publication_date",
                "corpus_size_type",
                "corpus_size_value",
                "document_title",
                "document_author_forename",
                "document_author_surname",
                "document_merged_authors",
                "document_editor_forename",
                "document_editor_surname",
                "document_languages_language",
                "document_languages_iso_code",
                "document_publication_place",
                "document_publication_publishing_date",
                "document_list_of_annotations_id",
                "document_size_type",
                "document_size_extent",
                "preparation_title",
                "preparation_annotation_id",
                "preparation_encoding_annotation_group",
                "preparation_encoding_annotation_sub_group",
                "preparation_encoding_full_name",
                "annotation_merged_formats",
                "in_documents"
            ),
            "query" =>  $request->input('search_terms'),
            "indices" => join(",",$publishedIndexes['allPublishedIndices'])
        );

        $result = $this->ElasticService->searchGeneral($searchData);


        for ($i = 0; $i < count($result['hits']['hits']); $i++) {
            $index = $result['hits']['hits'][$i]['_index'];
            if(strpos($index,"corpus") !== false) {
                $projectPath = $this->LaudatioUtils->getCorpusProjectPathByCorpusId($result['hits']['hits'][$i]['_id'],$index);
                $corpusPath = $this->LaudatioUtils->getCorpusPathByCorpusId($index,$index);
                $corpusLogo = $this->LaudatioUtils->getCorpusLogoByCorpusId($index,$index);
                $result['hits']['hits'][$i]['_source']['projectpath'] = $projectPath;
                $result['hits']['hits'][$i]['_source']['corpuspath'] = $corpusPath;
                $result['hits']['hits'][$i]['_source']['corpuslogo'] = $corpusLogo;
                $documentgenre = $this->LaudatioUtils->getDocumentGenreByCorpusId($index,$index);
                $result['hits']['hits'][$i]['_source']['documentgenre'] = $documentgenre;

                $current_document_index = str_replace("corpus","document",$index);

                $documentResult = $this->ElasticService->getDocumentByCorpus(
                    array(array("in_corpora" => $index)),
                    array($index),
                    array("document_publication_publishing_date"),
                    $current_document_index
                );

                $data = array("result" => $result['hits']['hits'][$i]['_source']);
                $document_range = $this->LaudatioUtils->getDocumentRange($data,$documentResult);
                $result['hits']['hits'][$i]['_source']['documentrange'] = $document_range;
            }
            else if(strpos($index,"document") !== false) {
                $corpusName = $this->LaudatioUtils->getCorpusNameByObjectElasticsearchId('document',$result['hits']['hits'][$i]['_id']);
                $result['hits']['hits'][$i]['_source']['corpus_name'] = $corpusName;
            }
            else if(strpos($index,"annotation") !== false) {
                $corpusName = $this->LaudatioUtils->getCorpusNameByObjectElasticsearchId('annotation',$result['hits']['hits'][$i]['_id']);
                $result['hits']['hits'][$i]['_source']['corpus_name'] = $corpusName;
            }

            $result['hits']['hits'][$i]['_source']['visibility'] = 1;

        }


        $resultData = array(
            'error' => false,
            'milliseconds' => $result['took'],
            'maxscore' => $result['hits']['max_score'],
            'results' => $result['hits']['hits'],
            'total' => $result['hits']['total']
        );

        JavaScript::put([
            "publishedIndexes" => $publishedIndexes,
            "frontPageResultData" => $resultData
        ]);

        return view('search.search')
            ->with('isLoggedIn', $isLoggedIn);
    }

}