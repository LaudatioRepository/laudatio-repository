<?php

/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 06.12.17
 * Time: 10:50
 */
namespace App\Laudatio\Utils;

use App\Custom\LaudatioUtilsInterface;
use Flow\JSONPath\JSONPath;


use App\CorpusProject;
use App\Corpus;
use App\Document;
use App\Annotation;
use App\CorpusFile;
use App\Preparation;
use App\Role;
use App\User;
use Log;
use Cache;
use DB;

class LaudatioUtilService implements LaudatioUtilsInterface
{

    /**
     * Parse xml to json
     * @param $xml
     * @param $options
     * @return array
     */
    public function parseXMLToJson($xml, $options){

        $defaults = array(
            'namespaceSeparator' => ':',//you may want this to be something other than a colon
            'attributePrefix' => '',   //to distinguish between attributes and nodes with the same name
            'alwaysArray' => array(),   //array of xml tag names which should always become arrays
            'autoArray' => true,        //only create arrays for tags which appear more than once
            'textContent' => 'text',       //key used for the text content of elements
            'autoText' => true,         //skip textContent key if node has no attributes or child nodes
            'keySearch' => false,       //optional search and replace on tag and attribute names
            'keyReplace' => false       //replace values for above search values (as passed to str_replace())
        );

        $options = array_merge($defaults, $options);
        $namespaces = $xml->getDocNamespaces();
        $namespaces[''] = null; //add base (empty) namespace


        //get attributes from all namespaces
        $attributesArray = array();
        foreach ($namespaces as $prefix => $namespace) {
            foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
                //replace characters in attribute name
                if ($options['keySearch']) $attributeName =
                    str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
                $attributeKey = $options['attributePrefix']
                    . ($prefix ? $prefix . $options['namespaceSeparator'] : '')
                    . $attributeName;
                $attributesArray[$attributeKey] = (string)$attribute;
            }

            foreach ($xml->attributes('xml', TRUE) as $attributeName => $attribute) {
                //replace characters in attribute name
                if ($options['keySearch']) $attributeName =
                    str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
                $attributeKey = $options['attributePrefix']
                    . ($prefix ? $prefix . $options['namespaceSeparator'] : '')
                    . $attributeName;
                $attributesArray[$attributeKey] = (string)$attribute;
            }

            
        }

        //get child nodes from all namespaces
        $tagsArray = array();
        foreach ($namespaces as $prefix => $namespace) {
            foreach ($xml->children($namespace) as $childXml) {
                //recurse into child nodes
                $childArray = $this->parseXMLToJson($childXml, $options);
                list($childTagName, $childProperties) = each($childArray);

                //replace characters in tag name
                if ($options['keySearch']) $childTagName =
                    str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
                //add namespace prefix, if any
                if ($prefix) $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;

                if (!isset($tagsArray[$childTagName])) {
                    //only entry with this key
                    //test if tags of this type should always be arrays, no matter the element count

                    $tagsArray[$childTagName] =
                        in_array($childTagName, $options['alwaysArray']) || !$options['autoArray']
                            ? array($childProperties) : $childProperties;
                            //? array($childProperties) : array($childProperties);
                } elseif (
                    is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName])
                    === range(0, count($tagsArray[$childTagName]) - 1)
                ) {
                    //key already exists and is integer indexed array
                    $tagsArray[$childTagName][] = $childProperties;
                } else {
                    //key exists so convert to integer indexed array with previous value in position 0
                    $tagsArray[$childTagName] = array($tagsArray[$childTagName], $childProperties);
                }
            }
        }

        //get text content of node
        $textContentArray = array();
        $plainText = trim((string)$xml);
        $plainText = str_replace("\n","",$plainText);
        $plainText = str_replace("\r","",$plainText);
        $plainText = str_replace("\r\n","",$plainText);
        $plainText = str_replace(' +', ' ', $plainText);

        if ($plainText !== '') $textContentArray[$options['textContent']] = $plainText;

        //stick it all together
        $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '')
            ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;

        return array(
            $xml->getName() => $propertiesArray
        );
    }

    /**
     * Populate Corpus  object with attributes from the Corpus Header
     * @param $json
     * @param $params
     * @return mixed|static
     */
    public function setCorpusAttributes($json,$params){
        $jsonPath = new JSONPath($json,JSONPath::ALLOW_MAGIC);
        $corpusId = $jsonPath->find('$.TEI.teiHeader.fileDesc.titleStmt.title.id')->data();
        $corpusTitle = $jsonPath->find('$.TEI.teiHeader.fileDesc.titleStmt.title.text')->data();
        $corpusDesc = $jsonPath->find('$.TEI.teiHeader.encodingDesc[0].projectDesc.p.text')->data();
        $corpusSizeType = $jsonPath->find('$.TEI.teiHeader.fileDesc.extent.type')->data();
        $corpusSizeValue = $jsonPath->find('$.TEI.teiHeader.fileDesc.extent.text')->data();

        $corpus = Corpus::find($params['corpusId']);
        $corpus->update([
            "name" => $corpusTitle[0],
            "description" => $corpusDesc[0],
            "corpus_size_type" => $corpusSizeType[0],
            "corpus_size_value" => $corpusSizeValue[0],
            "publication_version" => $params['publication_version'],
            "workflow_status" => 0,
            'uid' => $params['uid'],
            'gitlab_group_id' => $params['gitlab_group_id'],
            'directory_path' => $params['corpus_path'],
            'corpus_id' => count($corpusId) > 0 ? $corpusId[0] : uniqid('corpus_'),
            'gitlab_id' => $params['gitlab_id'],
            'gitlab_web_url' => $params['gitlab_web_url'],
            'gitlab_ssh_url' => $params['gitlab_ssh_url'],
            'gitlab_namespace_path' => $params['gitlab_name_with_namespace'],
            "file_name" => $params['file_name'],
            "elasticsearch_index" => $params['elasticsearch_index'],
            "guidelines_elasticsearch_index" => $params['guidelines_elasticsearch_index'],
        ]);


        return $corpus;
    }

    public function updateCorpusAttributes($params, $corpusId){
        $corpus = Corpus::find($corpusId);
        $corpus->update($params);
        return $corpus;
    }

    public function updateCorpusFileAttributes($corpus){
        $updated = true;

        try{
            foreach ($corpus->corpusfiles as $corpusfile) {
                $corpusfile->directory_path = $corpus->directory_path;
                $corpusfile->save();
            }
        }
        catch(\Exception $e) {
            $updated = false;
        }

        return $updated;
    }

    public function duplicateCorpus($oldCorpus, $new_corpus_elasticsearch_id,$new_corpus_id, $new_corpus_index, $new_guideline_index, $now,$oldDocumentIndex,$oldAnnotationIndex,$new_document_index,$new_annotation_index){
        $elasticsearchIndexes = array();
        //create a new corpus to represent the new working period
        $new_corpus = new Corpus();

        $new_corpus->name = $oldCorpus->name;
        $new_corpus->uid = $oldCorpus->uid;
        $new_corpus->description = $oldCorpus->description;
        $new_corpus->corpus_size_type = $oldCorpus->corpus_size_type;
        $new_corpus->corpus_size_value = $oldCorpus->corpus_size_value;
        $new_corpus->directory_path = $oldCorpus->directory_path;
        $new_corpus->corpus_id = $new_corpus_id;
        $new_corpus->file_name = $oldCorpus->file_name;
        $new_corpus->elasticsearch_id = $new_corpus_elasticsearch_id;
        $new_corpus->guidelines_elasticsearch_index = $new_guideline_index;
        $new_corpus->elasticsearch_index = $new_corpus_index;
        $new_corpus->publication_version = "working_period";
        $new_corpus->gitlab_group_id = $oldCorpus->gitlab_group_id;
        $new_corpus->gitlab_id = $oldCorpus->gitlab_id;
        $new_corpus->gitlab_web_url = $oldCorpus->gitlab_web_url;
        $new_corpus->gitlab_namespace_path = $oldCorpus->gitlab_namespace_path;
        $new_corpus->workflow_status = 0;
        $new_corpus->save();

        //attach user roles

        $corpusUser = User::find($new_corpus->uid);
        $corpusAdminRole = Role::findById(3);
        $corpusUser->roles()->sync($corpusAdminRole);
        if($corpusUser) {
            if(!$corpusUser->roles->contains($corpusAdminRole)){
                $corpusUser->roles()->attach($corpusAdminRole);
            }

            $new_corpus->users()->save($corpusUser,['role_id' => 3]);
        }


        /* for each corpusproject attached to this corpus, detach the old corpus (?),
        and attach the new corpus to the corpus project for the next working period
        */

        $corpusProjects = $oldCorpus->corpusprojects()->get();
        foreach($corpusProjects as $corpusProject) {
            //$corpusProject->corpora()->detach($corpus->id);
            $new_corpus->corpusprojects()->attach($corpusProject);
        }

        $prefixarray = explode("§",$new_corpus_id);

        $documentElasticsearchIndexes = array();
        $documentElasticsearchIndexes['prefix'] = $prefixarray[0];
        $documentElasticsearchIndexes['indexes'] = array();
        $documentElasticsearchIndexes['indexes'][$oldDocumentIndex] = array();
        foreach ($oldCorpus->documents()->get() as $document) {
            $new_document_elasticsearch_id = $now."§".$document->elasticsearch_id;
            array_push($documentElasticsearchIndexes['indexes'][$oldDocumentIndex],$new_document_elasticsearch_id);
            $newDocument = new Document();
            $newDocument->title = $document->title;
            $newDocument->uid = $document->uid;
            $newDocument->file_name = $document->file_name;
            $newDocument->document_genre = $document->document_genre;
            $newDocument->document_size_type = $document->document_size_type;
            $newDocument->document_size_value = $document->document_size_value;
            $newDocument->document_id = $document->document_id;
            $newDocument->corpus_id = $new_corpus->id;
            $newDocument->elasticsearch_id = $new_document_elasticsearch_id;
            $newDocument->elasticsearch_index = $new_document_index;
            $newDocument->publication_version = $document->publication_version;
            $newDocument->directory_path = $document->directory_path;
            $newDocument->workflow_status = 0;
            $newDocument->save();
            $new_corpus->documents()->save($newDocument);
            $document->workflow_status = 1;
            $document->save();
        }
        $elasticsearchIndexes['document'] = $documentElasticsearchIndexes;

        $annotationElasticsearchIndexes = array();
        $annotationElasticsearchIndexes['prefix'] = $prefixarray[0];
        $annotationElasticsearchIndexes['indexes'] = array();
        $annotationElasticsearchIndexes['indexes'][$oldAnnotationIndex] = array();
        foreach ($oldCorpus->annotations()->get() as $annotation) {
            $new_annotation_elasticsearch_id = $now."§".$annotation->elasticsearch_id;
            array_push($annotationElasticsearchIndexes['indexes'][$oldAnnotationIndex],$new_annotation_elasticsearch_id);
            $newAnnotation = new Annotation();
            $newAnnotation->uid = $annotation->uid;
            $newAnnotation->file_name = $annotation->file_name;
            $newAnnotation->annotation_id = $annotation->annotation_id;
            $newAnnotation->annotation_group = $annotation->annotation_group;
            $newAnnotation->annotation_size_type = $annotation->annotation_size_type;
            $newAnnotation->annotation_size_value = $annotation->annotation_size_value;
            $newAnnotation->corpus_id = $new_corpus->id;
            $newAnnotation->elasticsearch_id = $new_annotation_elasticsearch_id;
            $newAnnotation->elasticsearch_index = $new_annotation_index;
            $newAnnotation->publication_version = $annotation->publication_version;
            $newAnnotation->directory_path = $annotation->directory_path;
            $newAnnotation->workflow_status = 0;
            $newAnnotation->save();
            foreach ($annotation->documents()->get() as $annodocu){
                $newAnnotation->documents()->attach($annodocu);
            }
            $annotation->workflow_status = 1;
            $annotation->save();
        }

        $elasticsearchIndexes['annotation'] = $annotationElasticsearchIndexes;

        return $elasticsearchIndexes;
    }

    /**
     * Checks if Corpus is versioned and
     * @param $corpusId
     * @return bool
     */
    public function corpusIsVersioned($corpusId){
        $isVersioned = false;
        $corpus = Corpus::findOrFail($corpusId);

        if($corpus->vid >= 1){
            $isVersioned = true;
        }
        return $isVersioned;
    }

    /**
     * Populate Document object with attributes fom the Document header
     * @param $json
     * @param $corpusId
     * @param $fileName
     * @return Document
     */
    public function setDocumentAttributes($json,$corpusId,$uid,$fileName,$isDir){
        $jsonPath = new JSONPath($json);

        $documentTitle = $jsonPath->find('$.TEI.teiHeader.fileDesc.titleStmt.title.text')->data();
        if(!$documentTitle){
            $documentTitle = $jsonPath->find('$.TEI.teiHeader.fileDesc.titleStmt.title')->data();
        }

        $document_id = $jsonPath->find('$.TEI.teiHeader.fileDesc.id')->data();

        $documentGenre = $jsonPath->find('$.TEI.teiHeader.style')->data();


        $documentSizeType = $jsonPath->find('$.TEI.teiHeader.fileDesc.extent.type')->data();


        $documentSizeValue = $jsonPath->find('$.TEI.teiHeader.fileDesc.extent.text')->data();

        $encodingDesc = $jsonPath->find('$.TEI.teiHeader.encodingDesc.schemaSpec.elementSpec[*]')->data();


        $document = null;
        $documentObject = $this->getModelByFileAndCorpus($fileName,'document',$isDir,$corpusId);
        $corpus = Corpus::find($corpusId);

        if(count($documentObject) > 0){
            $document = $documentObject[0];
            $document->title = $documentTitle[0];
            $document->document_genre = count($documentGenre) > 0 ? $documentGenre[0] : "";
            $document->document_size_type = count($documentSizeType) > 0 ? $documentSizeType[0]: "";
            $document->document_size_value = count($documentSizeValue) > 0 ? $documentSizeValue[0]: 0;
            $document->document_id = $document_id[0];
            $document->corpus_id = $corpusId;
            $document->uid = $uid;
            $document->file_name = $fileName;
            $document->directory_path = $corpus->directory_path;
            $document->save();
        }
        else{
            $document = new Document;
            $document->title = $documentTitle[0];
            $document->document_genre = count($documentGenre) > 0 ? $documentGenre[0] : "";
            $document->document_size_type = count($documentSizeType) > 0 ? $documentSizeType[0]: "";
            $document->document_size_value = count($documentSizeValue) > 0 ? $documentSizeValue[0]: 0;
            $document->document_id = $document_id[0];
            $document->corpus_id = $corpusId;
            $document->uid = $uid;
            $document->directory_path = $corpus->directory_path;
            $document->file_name = $fileName;
            $document->save();
        }


        /*
         * Populate database with list of annotations, with document_id and corpus_id as compound primary_key
         */

        foreach ($encodingDesc as $annotationJson) {

            $annotationPath = new JSONPath($annotationJson,JSONPath::ALLOW_MAGIC);
            $annotationGroup = $annotationPath->find('$.ident')->data();
            $annotations = $annotationPath->find('$.valList.valItem[*]')->data();
            foreach ($annotations as $annotation) {
                $annotationValue = "";
                if(is_array($annotation)){
                    $annotationValue = $annotation['corresp'];
                }
                else{
                    $annotationValue = $annotation;
                }

                $annotationsFromDB = Annotation::where(
                    [
                        ['annotation_id', '=', $annotationValue],
                        ['corpus_id', '=', $corpusId],
                    ]
                )->get();

                if(count($annotationsFromDB) == 0){
                    $annotationObject = new Annotation;
                    $annotationObject->annotation_id = $annotationValue;
                    $annotationObject->corpus_id = $corpusId;
                    $annotationObject->directory_path = $corpus->directory_path;
                    $annotationObject->annotation_group = $annotationGroup[0];
                    $annotationObject->save();
                    $annotationObject->documents()->attach($document);
                }
                else{
                    $annotationObject = $annotationsFromDB[0];
                    $annotationObject->documents()->attach($document);
                }//end if
            }//end foreach

        }//end foreach

        return $document;
    }

    /**
     * setCommitData
     *
     * @param $commitData
     * @param $corpusId
     * @return bool
     */
    public function setCommitData($commitData,$corpusId) {
        $setData = true;

        try {
            foreach ($commitData as $path => $data) {
                $pathArray = explode("/",$path);

                if(strrpos($path,"corpus") !== false) {
                    $fileName = $pathArray[2];
                    $object = $this->getModelByFileAndCorpus($fileName, "corpus", false, $corpusId);
                }
                else if(strrpos($path,"document") !== false) {
                    $fileName = $pathArray[2];
                    $object = $this->getModelByFileAndCorpus($fileName, "document", false, $corpusId);
                }
                else if(strrpos($path,"annotation") !== false) {
                    $fileName = $pathArray[2];
                    $object = $this->getModelByFileAndCorpus($fileName, "annotation", false, $corpusId);
                }
                else if(strrpos($path,"CORPUS-DATA") !== false) {
                    $fileName = $pathArray[1];
                    $object = $this->getModelByFileName($fileName,"CORPUS-DATA",false,$corpusId);
                }

                $params = array(
                    "gitlab_commit_sha" => $data['sha_string'],
                    "gitlab_commit_date" => $data['date'],
                    "gitlab_commit_description" => $data['date'],
                );
                /*
                $object->gitlab_commit_sha = $data['sha_string'];
                $object->gitlab_commit_date = $data['message'];
                $object->gitlab_commit_description = $data['message'];
                */
                $object->update($params);
            }
        }
        catch (\Exception $e) {
            $setData = false;
            Log::info("setCommitData: error: ".$e->getMessage());
        }



        return $setData;
    }

    public function updateDocumentAttributes($params,$documentId){
        $document = Document::find($documentId);
        $document->update($params);
        return $document;
    }


    /**
     * @param $documentId
     * @return bool
     */
    public function documentIsVersioned($documentId){
        $isVersioned = false;
        $document = Document::findOrFail($documentId);

        if($document->vid >= 1){
            $isVersioned = true;
        }
        return $isVersioned;
    }

    /**
     * Populate Annotation object with attributes from the Annotation Header
     * @param $json
     * @param $corpusId
     * @param $fileName
     * @return Annotation|mixed
     */
    public function setAnnotationAttributes($json,$corpusId,$uid,$fileName,$isDir){
        $jsonPath = new JSONPath($json);

        $annotationId = $jsonPath->find('$.TEI.teiHeader.fileDesc.titleStmt.title.corresp')->data();
        $annotationSizeType = $jsonPath->find('$.TEI.teiHeader.fileDesc.extent.type')->data();
        $annotationSizeValue = $jsonPath->find('$.TEI.teiHeader.fileDesc.extent.text')->data();

        $annotationsFromDB = Annotation::where(
            [
                ['annotation_id', '=', $annotationId[0]],
                ['corpus_id', '=', $corpusId],
            ]
        )->get();


        $corpus = Corpus::find($corpusId);

        if(count($annotationsFromDB) > 0){
            foreach($annotationsFromDB as $annotationFromDB)
              $annotationFromDB->update([
                  "annotation_size_type" => $annotationSizeType[0],
                  "annotation_size_value" => $annotationSizeValue[0],
                  "directory_path" => $corpus->directory_path,
                  "file_name" => $fileName,
                  "uid" => $uid
            ]);

            $annotationFromDB->save();

            return $annotationFromDB;
        }
        else{
            $annotation = new Annotation;
            $annotation->annotation_id = $annotationId[0];
            $annotation->annotation_size_type = $annotationSizeType[0];
            $annotation->annotation_size_value = $annotationSizeValue[0];
            $annotation->corpus_id = $corpusId;
            $annotation->uid = $uid;
            $annotation->file_name = $fileName;
            $annotation->directory_path = $corpus->directory_path;
            $annotation->save();
            return $annotation;
        }
    }

    public function setPreparationAttributes($json,$annotationId,$corpusId,$isDir){
        $jsonPath = new JSONPath($json);
        $preparationFromDB = Preparation::where([
            ['annotation_id', '=', $annotationId],
            ['corpus_id', '=', $corpusId],
        ])->get();


        if(count($preparationFromDB) > 0){

        }
        else{

            $preparationEncodingSteps = $jsonPath->find('$.TEI.teiHeader.encodingDesc[*]')->data();

            if(!is_array($preparationEncodingSteps[0])){
                $preparationEncodingSteps = array(
                    array(
                        'n' => $preparationEncodingSteps[0],
                        'style' => $preparationEncodingSteps[1],
                        'appInfo' => $preparationEncodingSteps[2],
                        'editorialDecl' => isset($preparationEncodingSteps[3]) ? $preparationEncodingSteps[3] : "",
                        'projectDesc' => isset($preparationEncodingSteps[4]) ? $preparationEncodingSteps[4] : "",
                    )

                );
            }

            foreach ($preparationEncodingSteps as $preparationEncodingStep) {
                $preparation = new Preparation;
                $preparation->preparation_encoding_step = $preparationEncodingStep['style'];
                $preparation->preparation_encoding_style = $preparationEncodingStep['appInfo']['style'];
                $preparation->preparation_encoding_tool =  $preparationEncodingStep['appInfo']['application']['ident'];
                $preparation->preparation_encoding_full_name = $preparationEncodingStep['appInfo']['application']['label'];
                $preparation->preparation_encoding_description = $preparationEncodingStep['appInfo']['application']['p'];
                $preparation->preparation_encoding_annotation_style = $preparationEncodingStep['appInfo']['application']['style'];
                $preparation->preparation_encoding_segmentation_style = isset($preparationEncodingStep['editorialDecl']['segmentation']) ? $preparationEncodingStep['editorialDecl']['segmentation']['style'] : "";
                if(isset($preparationEncodingStep['editorialDecl']['segmentation']['corresp'])){
                    $preparation->preparation_encoding_segmentation_type = $preparationEncodingStep['editorialDecl']['segmentation']['corresp'];
                }
                else{
                    $preparation->preparation_encoding_segmentation_type = "NA";
                }
                if(isset($preparationEncodingStep['editorialDecl']['segmentation']['p'])){
                    $preparation->preparation_encoding_segmentation_description = $preparationEncodingStep['editorialDecl']['segmentation']['p'];
                }
                else{
                    $preparation->preparation_encoding_segmentation_description = "NA";
                }

                $preparation->annotation_id = $annotationId;
                $preparation->corpus_id = $corpusId;
                $preparation->save();
            }
        }
    }

    public function updateAnnotationAttributes($params,$annotationId){
        $annotation = Annotation::find($annotationId);
        $annotation->update($params);
        return $annotation;
    }

    public function annotationIsVersioned($annotationId){
        $isVersioned = false;
        $annotation = Annotation::findOrFail($annotationId);

        if($annotation->vid >= 1){
            $isVersioned = true;
        }
        return $isVersioned;
    }


    /**
     * Associate an array of Document objects to a Corpus
     * @param $documents
     * @param $corpusId
     * @return mixed|static Corpus
     */
    public function associateDocumentsToCorpus($documents,$corpusId){
        $corpus = Corpus::find($corpusId);

        foreach($documents as $document){
            $corpus->documents()->save($document);
        }
        return $corpus;
    }

    /**
     * Associate an array of Annotation objects to a Document
     * @param $annotations
     * @param $documentId
     * @return mixed|static Document
     */
    public function associateAnnotationsToDocument($annotations,$documentId){
        $document = Document::find($documentId);

        foreach ($annotations as $annotation) {
            $document->annotations()->save($annotation);
        }

        return $document;
    }

    /**
     * Associate an array of Annotation objects to a Corpus
     * @param $annotations
     * @param $corpusId
     * @return mixed|static Corpus
     */
    public function associateAnnotationsToCorpus($annotations,$corpusId){
        $corpus = Corpus::find($corpusId);
        foreach ($annotations as $annotation) {
            $corpus->annotations()->save($annotation);
        }

        return $corpus;
    }

    /**
     * Associate an array of Preparation objects to an Annotation
     * @param $preparations
     * @param $annotationId
     * @return mixed|static Annotation
     */
    public function associatePreparationsToAnnotation($preparations,$annotationId){
        $annotation = Annotation::find($corpusId);
        foreach ($preparations as $preparation) {
            $annotation->preparations()->save($preparation);
        }

        return $annotation;
    }


    /**
     * Set the version mapping for each version of a header
     * @param $object
     * @return mixed
     */
    public function setVersionMapping($object){

        if(count($object) > 0){
            if(null != $object->vid){
                $object->vid++;
            }
            else{
                $object->vid = 1;
            }


            $object->save();

            $id_vid = DB::table('versions')->select('id', 'vid')->where([
                    ['id','=',$object->id],
                    ['type','=',$type],
                ]
            )->get();

            if(count($id_vid) > 0){
                DB::table('versions')->where('id',$object->id)->update(
                    ['vid' => $object->vid]
                );
            }
            else{
                DB::table('versions')->insert(
                    [
                        'id' => $object->id,
                        'vid' => $object->vid,
                        'type' => $type
                    ]
                );
            }
        }

        return $object->vid;

    }


    /**
     * Set the version mapping for each version of a header
     *
     * @param $fileName
     * @param $type
     * @param $isDir
     * @param $corpusid
     * @return mixed
     */
    public function setVersionMapping_old($fileName,$type, $isDir,$corpusid){
        $object = $this->getModelByFileAndCorpus($fileName,$type, $isDir,$corpusid);

        if(count($object) > 0){
            if(null != $object[0]->vid){
                $object[0]->vid++;
            }
            else{
                $object[0]->vid = 1;
            }


            $object[0]->save();

            $id_vid = DB::table('versions')->select('id', 'vid')->where([
                    ['id','=',$object[0]->id],
                    ['type','=',$type],
                ]
            )->get();

            if(count($id_vid) > 0){
                DB::table('versions')->where('id',$object[0]->id)->update(
                    ['vid' => $object[0]->vid]
                );
            }
            else{
                DB::table('versions')->insert(
                    [
                        'id' => $object[0]->id,
                        'vid' => $object[0]->vid,
                        'type' => $type
                    ]
                );
            }
        }

        return $object[0]->vid;

    }

    public function getModelByType($id,$type){
        $object = null;
        switch ($type){
            case 'corpus':
                $object = Corpus::find($id);
                break;
            case 'document':
                $object = Document::find($id);
                break;
            case 'annotation':
                $object = Annotation::find($id);
                break;
        }
        return $object;
    }

    /**
     * Fetch a Model by type and filename
     * @param $fileName
     * @param $type
     * @return mixed
     * @todo: This is very brittle, we need some kind of GUID, and to add at least the corpus id to avoid ambiguity
     */
    public function getModelByFileName($fileName, $type, $isDir,$corpusId){
        $object = null;
        switch ($type){
            case 'corpus':
                if($isDir){
                    $object = Corpus::where([
                        ['directory_path', '=',$fileName],
                        ['corpus_id', '=',$corpusId]
                    ])->get();
                }
                else{
                    $object = Corpus::where([
                        ['file_name', '=',$fileName],
                        ['corpus_id', '=',$corpusId]
                    ])->get();
                }
                break;
            case 'document':
                if($isDir){
                    $object = Document::where([
                        ['directory_path', '=',$fileName],
                        ['corpus_id', '=',$corpusId]
                    ])->get();
                }
                else{
                    $object = Document::where([
                        ['file_name', '=',$fileName],
                        ['corpus_id', '=',$corpusId]
                    ])->get();
                }

                break;
            case 'annotation':
                if($isDir){
                    $object = Annotation::where([
                        ['directory_path', '=',$fileName],
                        ['corpus_id', '=',$corpusId]
                    ])->get();
                }
                else{
                    $object = Annotation::where([
                        ['file_name', '=',$fileName],
                        ['corpus_id', '=',$corpusId]
                    ])->get();
                }

                break;
            case 'CORPUS-DATA':
                $object = CorpusFile::where([
                    ['file_name', '=',$fileName],
                    ['corpus_id', '=',$corpusId]
                ])->get();
                break;
        }
        return $object[0];
    }

    /**
     * @param $fileName
     * @param $type
     * @param $isDir
     * @param $corpusId
     * @return \Illuminate\Support\Collection|null
     */
    public function getModelByFileAndCorpus($fileName, $type, $isDir, $corpusId){
        $object = null;
        switch ($type){
            case 'corpus':
                if($isDir){
                    $object = Corpus::where([
                        ['directory_path', '=',$fileName],
                        ['id', '=',$corpusId]
                    ])->get();
                }
                else{
                    $object = Corpus::where([
                        ['file_name', '=',$fileName],
                        ['id', '=',$corpusId]
                    ])->get();
                }
                break;
            case 'document':
                if($isDir){
                    $object = Document::where([
                        ['directory_path', '=',$fileName],
                        ['corpus_id', '=',$corpusId]
                    ])->get();
                }
                else{
                    $object = Document::where([
                        ['file_name', '=',$fileName],
                        ['corpus_id', '=',$corpusId]
                    ])->get();
                }

                break;
            case 'annotation':
                if($isDir){
                    $object = Annotation::where([
                        ['directory_path', '=',$fileName],
                        ['corpus_id', '=',$corpusId]
                    ])->get();
                }
                else{
                    $fileName = substr($fileName,strrpos($fileName,".")-1);

                    $object = Annotation::where([
                        ['file_name', '=',$fileName],
                        ['corpus_id', '=',$corpusId]
                    ])->get();
                }

                break;
        }
        return $object[0];
    }

    public function getElasticSearchIdByCorpusId($corpusid,$corpus_index)
    {
        $corpus = Corpus::where([["corpus_id","=",$corpusid],["elasticsearch_index","=",$corpus_index]])->get();
        return $corpus[0]->elasticsearch_id;
    }

    public function getElasticSearchIndexByCorpusId($corpusid)
    {
        $corpus = Corpus::find($corpusid);
        return $corpus->elasticsearch_index;
    }


    public function getDatabaseIdByCorpusId($corpusid)
    {
        $corpus = Corpus::where("corpus_id",$corpusid)->get();
        return $corpus[0]->id;
    }

    public function  getCurrentCorpusIndexByElasticsearchId($elasticSearchId) {
        $corpus = Corpus::where([
            ["elasticsearch_id","=",$elasticSearchId]
        ])->get();
        return $corpus[0]->elasticsearch_index;
    }

    public function getCurrentDocumentIndexByElasticsearchId($elasticSearchId){
        $document = Document::where([
            ["elasticsearch_id","=",$elasticSearchId]
        ])->get();
        return $document[0]->elasticsearch_index;
    }

    public function getCurrentAnnotationIndexByElasticsearchId($elasticSearchId){
        $annotation = Annotation::where([
            ["elasticsearch_id","=",$elasticSearchId]
        ])->get();
        return $annotation[0]->elasticsearch_index;
    }

    public function getCurrentCorpusIndexByAnnotationElasticsearchId($elasticSearchId){
        $annotation = Annotation::where([
            ["elasticsearch_id","=",$elasticSearchId]
        ])->get();

        $corpus = $annotation[0]->corpus()->get();
        return $corpus[0]->elasticsearch_index;
    }



    public function getCurrentCorpusIndexByDocumentElasticsearchId($elasticSearchId){
        $document = Document::where([
            ["elasticsearch_id","=",$elasticSearchId]
        ])->get();
        $corpus = $document[0]->corpus()->get();
        return $corpus[0]->elasticsearch_index;
    }

    public function getDocumentGenreByCorpusId($corpusid,$index)
    {
        $genre = "N/A";

        $corpus = Corpus::where([["corpus_id","=",$corpusid],["elasticsearch_index","=",$index]])->get();
        if(isset($corpus[0])){
            $documents = $corpus[0]->documents()->get();
            $genre = isset($documents[0]) ? $documents[0]->document_genre : "N/A";
        }

        return $genre;
    }
    public function getCorpusVersion($corpusId){
        $corpus = Corpus::where("corpus_id",$corpusId)->get();
        return $corpus[0]->publication_version;
    }
    public function getWorkFlowStatus($corpusId){
        $corpus = Corpus::where("corpus_id",$corpusId)->get();
        return $corpus[0]->workflow_status;
    }

    public function getCorpusPathByCorpusId($corpusid,$corpus_index){
        $corpusPath = "";
        $corpus = Corpus::where([["corpus_id","=",$corpusid],["elasticsearch_index","=",$corpus_index]])->get();
        if(isset($corpus[0])){
            $corpusprojects = $corpus[0]->corpusprojects()->get();
            $project = $corpusprojects[0];
            $corpusPath = $project->directory_path."/".$corpus[0]->directory_path;
        }

        return $corpusPath;
    }

    public function getLicenseByCorpus($data){

    }

    public function deleteModels($path){
        $dirArray = explode("/",$path);
        $type = $dirArray[3];
        $objects = null;
        switch ($type) {
            case 'corpus':
                $objects = DB::table('corpuses')->where('directory_path',$dirArray[1])->get();
                break;
            case 'document':
                $objects = DB::table('documents')->where('directory_path',$dirArray[1])->get();
                break;
            case 'annotation':
                $objects = DB::table('annotations')->where('directory_path',$dirArray[1])->get();
                break;
        }
        foreach ($objects->toArray() as $object){
            $this->deleteModel($type, $object->id);
        }
    }

    public function deleteModel($type,$id){
        $object = null;
        switch ($type) {
            case 'corpus':
                $object = Corpus::find($id);
                break;
            case 'document':
                $object = Document::find($id);
                if(count($object->annotations()) > 0) {
                    $object->annotations()->detach();
                }

                $object->delete();
                break;
            case 'annotation':
                $object = Annotation::find($id);
                if(count($object->documents()) > 0) {
                    $object->documents()->detach();
                }
                $object->preparations()->delete();
                $object->delete();
                break;
        }
    }

    public function updateDirectoryPaths($directory_path,$corpusId){
        DB::update("update documents set directory_path = ? where corpus_id = ?", [$directory_path,$corpusId]);
        DB::update("update annotations set directory_path = ? where corpus_id = ?", [$directory_path,$corpusId]);
    }

    public function getDirectoryPath($paths,$fileName){
        $directoryPath = "";
        foreach ($paths as $path) {
            if (strpos($path,$fileName) !== false){
                $directoryPath = $path;
                break;
            }
        }
        return $directoryPath;
    }

    /**
     * buildCiteFormat creates citations for a given piece of data
     * @param $data
     * @return array
     */
    public function buildCiteFormat($data){
        $cite = "";
        $citedauthors = "";
        $authorstring = "";

        foreach ($data['authors'] as $authorData) {
            $namearray = explode(" ", $authorData);
            $citedauthors .= $namearray[1].",";
            $authorstring .= $namearray[1].", ".$namearray[0].",";
        }

        $citedauthors = substr($citedauthors,0,strrpos($citedauthors,","));
        $authorstring = substr($authorstring,0,strrpos($authorstring,","));
        $citedauthors .= $data['publishing_year'];
        
        $APAcite = $namearray[1].", ".
            substr($namearray[0],0,1).
            ". (".$data['publishing_year']."). ".
            $data['title']." (".$data['version']."). ".
            $data['publishing_institution'].".".
            "handle: ".$data['published_handle'].".";


        $CHIAGOcite = $namearray[1].", ".
            $namearray[0].".".
            "´".$data['title']." (".$data['version'].")´ ".
            $data['publishing_institution'].", ".$data['publishing_year'].".".
            "handle: ".$data['published_handle'].".";

        $HARVARDcite = $namearray[1].", ".
            substr($namearray[0],0,1).
            ". (".$data['publishing_year']."). ".
            "´".$data['title']." (".$data['version'].")´ ".
            $data['publishing_institution'].
            "handle: ". $data['published_handle'].".";


        $BibTexcite = "";
        $BibTexcite .= "@Misc{".$citedauthors.",\n";
        $BibTexcite .= "\t author \t = {".$authorstring."}, \n";
        $BibTexcite .= "\t title \t = {{".$data['title']." (Version ".$data['version'].")}}, \n";
        $BibTexcite .= "\t year \t = {".$data['publishing_year']."}, \n";
        $BibTexcite .= "\t note \t = {".$data['publishing_institution']."}, \n";
        $BibTexcite .= "\t url \t = {".$data['published_handle']."}, \n";
        $BibTexcite .= "}";

        $TXTcite = "";
        $TXTcite .= $citedauthors."\n";
        $TXTcite .= $authorstring."\n";
        $TXTcite .= $data['title']." (Version ".$data['version'].")\n";
        $TXTcite .= $data['publishing_year']."\n";
        $TXTcite .= $data['publishing_institution']."\n";
        $TXTcite .= $data['published_handle']."\n";

        $citations = array();
        $citations['apa'] = $APAcite;
        $citations['chicago'] = $CHIAGOcite;
        $citations['harvard'] = $HARVARDcite;
        $citations['bibtex'] = $BibTexcite;
        $citations['txt'] = $TXTcite;

        return $citations;
    }

    public function emptyCorpusCache($corpusId){
        Cache::tags(['corpus_'.$corpusId])->flush();

        Cache::tags(['formats_'.$corpusId])->flush();

        Cache::tags(['guidelines_'.$corpusId])->flush();
    }

    public function emptyDocumentCacheByCorpusId($corpusId){

        Cache::tags(['document_'.$corpusId])->flush();

        // @todo: flushes too all docs, and not only the relevant ones ?
        Cache::tags(['document'])->flush();

    }
    public function emptyDocumentCacheByDocumentId($documentId){
        Cache::tags(['document_'.$documentId])->flush();
    }

    public function emptyAnnotationCacheByCorpusId($corpusId){
        Cache::tags(['annotation_'.$corpusId])->flush();
        Cache::tags(['annotationgroup_'.$corpusId])->flush();

    }

    public function emptyAnnotationCacheByAnnotationId($annotationId){
        Cache::tags(['annotation_'.$annotationId])->flush();
    }
}
