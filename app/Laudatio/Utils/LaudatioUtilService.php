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
use App\Preparation;
use Log;
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
     * @param $corpusId
     * @param $fileName
     * @return mixed|static
     */
    public function setCorpusAttributes($json,$corpusId,$fileName){
        $jsonPath = new JSONPath($json,JSONPath::ALLOW_MAGIC);

        $corpusTitle = $jsonPath->find('$.TEI.teiHeader.fileDesc.titleStmt.title.text')->data();
        $corpusDesc = $jsonPath->find('$.TEI.teiHeader.encodingDesc[0].projectDesc.p.text')->data();
        $corpusSizeType = $jsonPath->find('$.TEI.teiHeader.fileDesc.extent.type')->data();
        $corpusSizeValue = $jsonPath->find('$.TEI.teiHeader.fileDesc.extent.text')->data();

        $corpus = Corpus::find($corpusId);
        $corpus->update([
            "name" => $corpusTitle[0],
            "description" => $corpusDesc[0],
            "corpus_size_type" => $corpusSizeType[0],
            "corpus_size_value" => $corpusSizeValue[0],
            "file_name" => $fileName

        ]);

        return $corpus;
    }

    /**
     * Populate Document object with attributes fom the Document header
     * @param $json
     * @param $corpusId
     * @param $fileName
     * @return Document
     */
    public function setDocumentAttributes($json,$corpusId,$fileName){
        $jsonPath = new JSONPath($json);
        $documentTitle = $jsonPath->find('$.TEI.teiHeader.fileDesc.titleStmt.title')->data();
        $documentGenre = $jsonPath->find('$.TEI.teiHeader.style')->data();
        $documentSizeType = $jsonPath->find('$.TEI.teiHeader.fileDesc.extent.type')->data();
        $documentSizeValue = $jsonPath->find('$.TEI.teiHeader.fileDesc.extent.text')->data();

        $documentListOfAnnotations = $jsonPath->find('$.TEI.teiHeader.encodingDesc.schemaSpec.elementSpec[*].valList.valItem[*].corresp')->data();

        $document = new Document;
        $document->title = $documentTitle[0];
        $document->document_genre = $documentGenre[0];
        $document->document_size_type = $documentSizeType[0];
        $document->document_size_value = $documentSizeValue[0];
        $document->corpus_id = $corpusId;
        $document->file_name = $fileName;
        $document->save();


        /*
         * Populate database with list of annotations, with document_id and corpus_id as compund primary_key
         */
        foreach ($documentListOfAnnotations as $annotation) {
            $annotationObject = new Annotation;
            $annotationObject->annotation_id = $annotation;
            $annotationObject->corpus_id = $corpusId;
            $annotationObject->document_id = $document->id;
            $document->file_name = $fileName;
            $annotationObject->save();
        }

        return $document;
    }

    /**
     * Populate Annotation object with attributes from the Annotation Header
     * @param $json
     * @param $corpusId
     * @param $fileName
     * @return Annotation|mixed
     */
    public function setAnnotationAttributes($json,$corpusId,$fileName){

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


        if(count($annotationsFromDB) > 0){

            foreach($annotationsFromDB as $annotationFromDB)
              $annotationFromDB->update([
                "annotation_size_type" => $annotationSizeType[0],
                "annotation_size_value" => $annotationSizeValue[0]
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
            $annotation->save();
            return $annotation;
        }
    }

    public function setPreparationAttributes($json,$annotationId,$corpusId){
        $jsonPath = new JSONPath($json);

        $preparationFromDB = Preparation::where([
            ['annotation_id', '=', $annotationId],
            ['corpus_id', '=', $corpusId],
        ])->get();


        if(count($preparationFromDB) > 0){

        }
        else{

            $preparationEncodingSteps = $jsonPath->find('$.TEI.teiHeader.encodingDesc[*]')->data();
            Log::info("preparationEncodingSteps: ".print_r($preparationEncodingSteps,1));
            foreach ($preparationEncodingSteps as $preparationEncodingStep) {
                $preparation = new Preparation;
                $preparation->preparation_encoding_step = $preparationEncodingStep['style'];
                $preparation->preparation_encoding_style = $preparationEncodingStep['appInfo']['style'];
                $preparation->preparation_encoding_tool =  $preparationEncodingStep['appInfo']['application']['ident'];
                $preparation->preparation_encoding_full_name = $preparationEncodingStep['appInfo']['application']['label'];
                $preparation->preparation_encoding_description = $preparationEncodingStep['appInfo']['application']['p'];
                $preparation->preparation_encoding_annotation_style = $preparationEncodingStep['appInfo']['application']['style'];
                $preparation->preparation_encoding_segmentation_style = $preparationEncodingStep['editorialDecl']['segmentation']['style'];
                $preparation->preparation_encoding_segmentation_type = $preparationEncodingStep['editorialDecl']['segmentation']['corresp'];
                $preparation->preparation_encoding_segmentation_description= $preparationEncodingStep['editorialDecl']['segmentation']['p'];
                $preparation->annotation_id = $annotationId;
                $preparation->corpus_id = $corpusId;
                $preparation->save();
            }
        }


        //Log::info("preparationEncodingSteps: ".print_r($preparationEncodingSteps,1));

        /*

        $preparation->update([
            "preparation_encoding_step" => $preparationEncodingStep[0],
            "preparation_encoding_style" => $preparationEncodingStyle[0],
            "preparation_encoding_tool" => $preparationEncodingTool[0],
            "preparation_encoding_full_name" => $preparationEncodingFullName[0],
            "preparation_encoding_description" => $preparationEncodingDescription[0],
            "preparation_encoding_annotation_style" => $preparationEncodingAnnotationStyle[0],
            "preparation_encoding_segmentation_style" => $preparationEncodingSegmentationStyle[0],
            "preparation_encoding_segmentation_type" => $preparationEncodingSegmentationType[0],
            "preparation_encoding_segmentation_description" => $preparationEncodingSegmentationDescription[0]
        ]);
        */
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
     * @param $id
     * @param $type
     */
    public function setVersionMapping($id,$type){
        $vid = 1;
        $object = $this->getModelByType($id,$type);
        if(null != $object->vid){
            $object->vid++;
        }
        //Log::info("objectvid: ".print_r($object->vid,1));
        $object->save();

        /**
         * @todo: must update, not insert new
         */
        DB::table('versions')->insert(
            [
                'id' => $id,
                'vid' => $object->vid,
                'type' => $type
            ]
        );
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
}