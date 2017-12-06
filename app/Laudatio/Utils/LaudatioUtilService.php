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

class LaudatioUtilService implements LaudatioUtilsInterface
{

    /**
     * @param $xml
     * @param $options
     * @param $format
     *
     * @return mixed
     */
    public function parseXMLToJson($xml, $options, $format = 'json'){
        $defaults = array(
            'namespaceSeparator' => ':',//you may want this to be something other than a colon
            'attributePrefix' => '§',   //to distinguish between attributes and nodes with the same name
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
                $childArray = xmlToArray($childXml, $options);
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



        if($format == 'json') {
            //return node as json
            return json_encode(array(
                $xml->getName() => $propertiesArray
            ));
        }
        else{
            //return node as array
            return array(
                $xml->getName() => $propertiesArray
            );
        }
    }

    /**
     * Populate Corpus  object with attributes from the Corpus Header
     * @param $json
     * @param $corpusId
     * @return mixed|static
     */
    public function setCorpusAttributes($json,$corpusId){
        $jsonPath = new JSONPath($json);
        $corpusTitle = $jsonPath->find('$.TEI.teiHeader.fileDesc.titleStmt.title.text');
        $corpusDesc = $jsonPath->find('$.TEI.teiHeader.encodingDesc[0].projectDesc.p.text');
        $corpusSizeType = $jsonPath->find('$.TEI.teiHeader.fileDesc.extent.type');
        $corpusSizeValue = $jsonPath->find('$.TEI.teiHeader.fileDesc.extent.text');

        $corpus = Corpus::find($corpusId);
        $corpus->update([
            "name" => $corpusTitle,
            "description" => $corpusDesc,
            "corpus_size_type" => $corpusSizeType,
            "corpus_size_value" => $corpusSizeValue
        ]);

        return $corpus;
    }

    /**
     * Populate Document object with attributes fom the Document header
     * @param $json
     * @param $documentId
     * @return mixed|static
     */
    public function setDocumentAttributes($json,$documentId){
        $jsonPath = new JSONPath($json);

        $documentTitle = $jsonPath->find('$.TEI.teiHeader.fileDesc.titleStmt.title.text');
        $documentGenre = $jsonPath->find('$.TEI.teiHeader.style');
        $documentSizeType = $jsonPath->find('$.TEI.teiHeader.fileDesc.extent.type');
        $documentSizeValue = $jsonPath->find('$.TEI.teiHeader.fileDesc.extent.text');

        $document = Document::find($documentId);
        $document->update([
            "title" => $documentTitle,
            "document_genre" => $documentGenre,
            "document_size_type" => $documentSizeType,
            "document_size_value" => $documentSizeValue
        ]);

        return $document;
    }

    /**
     * Pouplate Annotation object with attributes from the Annotation Header
     * @param $json
     * @param $annotationId
     * @return mixed|static
     */
    public function setAnnotationAttributes($json,$annotationId){
        $jsonPath = new JSONPath($json);

        $annotationId = $jsonPath->find('$.TEI.teiHeader.fileDesc.titleStmt.title.text');
        $annotationGroup = $jsonPath->find('$.TEI.teiHeader.encodingDesc.appInfo.application.type');
        $annotationSizeType = $jsonPath->find('$.TEI.teiHeader.fileDesc.extent.type');
        $annotationSizeValue = $jsonPath->find('$.TEI.teiHeader.fileDesc.extent.text');
        $annotation = Annotation::find($annotationId);
        $annotation->update([
            "annotation_id" => $annotationId,
            "annotation_group" => $annotationGroup,
            "annotation_size_type" => $annotationSizeType,
            "annotation_size_value" => $annotationSizeValue
        ]);
        return $annotation;
    }

    public function setPreparationAttributes($json,$preparationId){
        $jsonPath = new JSONPath($json);

        $preparation = Preparation::find($preparationId);
        $preparationEncodingStep = $jsonPath->find('$.TEI.teiHeader.encodingDesc.style');
        $preparationEncodingStyle = $jsonPath->find('$.TEI.teiHeader.encodingDesc.appInfo.style');
        $preparationEncodingTool = $jsonPath->find('$.TEI.teiHeader.encodingDesc.appInfo.application.ident');
        $preparationEncodingFullName = $jsonPath->find('$.TEI.teiHeader.encodingDesc.appInfo.application.label');
        $preparationEncodingDescription = $jsonPath->find('$.TEI.teiHeader.encodingDesc.appInfo.application.p');
        $preparationEncodingAnnotationStyle = $jsonPath->find('$.TEI.teiHeader.encodingDesc.appInfo.application.style');
        $preparationEncodingSegmentationStyle = $jsonPath->find('$.TEI.teiHeader.encodingDesc.editorialDecl.segmentation.style');
        $preparationEncodingSegmentationType = $jsonPath->find('$.TEI.teiHeader.encodingDesc.editorialDecl.segmentation.corresp');
        $preparationEncodingSegmentationDescription = $jsonPath->find('$.TEI.teiHeader.encodingDesc.editorialDecl.segmentation.p');

        $preparation->update([
            "preparation_encoding_step" => $preparationEncodingStep,
            "preparation_encoding_style" => $preparationEncodingStyle,
            "preparation_encoding_tool" => $preparationEncodingTool,
            "preparation_encoding_full_name" => $preparationEncodingFullName,
            "preparation_encoding_description" => $preparationEncodingDescription,
            "preparation_encoding_annotation_style" => $preparationEncodingAnnotationStyle,
            "preparation_encoding_segmentation_style" => $preparationEncodingSegmentationStyle,
            "preparation_encoding_segmentation_type" => $preparationEncodingSegmentationType,
            "preparation_encoding_segmentation_description" => $preparationEncodingSegmentationDescription
        ]);
    }
}