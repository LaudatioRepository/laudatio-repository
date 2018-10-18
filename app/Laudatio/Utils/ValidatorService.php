<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 09.10.18
 * Time: 09:38
 */

namespace App\Laudatio\Utils;

use App\Custom\ValidatorInterface;
use App\Exceptions\XMLNotValidException;
use App\Exceptions\XMLNotWellformedException;
use XMLReader;
use DOMDocument;
use Log;

class ValidatorService implements ValidatorInterface
{
    protected $xml;
    protected $schema;
    protected $rng_schema;
    protected $xml_reader;

    public function __construct()
    {
        $this->xml_reader = new XMLReader();

    }

    /**
     * @return mixed
     */
    public function getXml()
    {
        return $this->xml;
    }


    /**
     * @param $xml
     */
    public function setXml($xml)
    {
        $this->xml = $xml;
    }

    /**
     * @return mixed
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * @param $schema
     */
    public function setSchema($schema)
    {
        $this->schema = $schema;
        $this->xml_reader->setSchema($schema);
    }


    /**
     * @return mixed
     */
    public function getRelaxNGSchema()
    {
        return $this->rng_schema;
    }


    /**
     * @param $rng_schema
     */
    public function setRelaxNGSchema($rng_schema)
    {
        $this->xml_reader->open($this->xml);
        $this->xml_reader->setRelaxNGSchema($rng_schema);
    }

    /**
     * @param bool $json
     * @return string
     */
    public function isWellFormed($json = true){
        $this->xml_reader->open($this->xml);
        $isWellformed = array(
            "isWellFormed" => "true",
            "errors" => array()
        );
        libxml_use_internal_errors(true);

        $sxe = simplexml_load_string(file_get_contents($this->xml));
        if ($sxe === false) {
            $isWellformed['isWellFormed'] = "false";

            foreach(libxml_get_errors() as $error) {
                array_push($isWellformed['errors'],str_replace("\n","",$error->message));
            }

            throw new XMLNotWellformedException(join(",",$isWellformed['errors']),0,null);
        }


        if($json){
            return json_encode($isWellformed);
        }
        else{
            return $isWellformed['isWellFormed'];
        }

    }

    public function isXMLContentValid()
    {

        libxml_use_internal_errors(true);

        $this->debug('$this->nodes->length' .': '.$this->nodes->length);
        if ($this->nodes->length > 0) {
            foreach ($this->nodes as $node) {
                $part = new \DOMDocument('1.0', 'utf-8');
                $part->appendChild($part->importNode($node, true));
            }
            if (!$part->relaxNGValidate($this->schema)) {
                foreach(libxml_get_errors() as $error) {
                    $this->error(trim($error->message) .' (line '.$error->line. ')');
                }
                return false;
            }
        } else {
            throw new XMLNotValidException(join(",",$isValid['errors']),0,null);
        }

        return true;

    }


    /**
     * @param bool $json
     * @return mixed|string
     */
    public function isValidByRNG($json = true){
        $isValid = array(
            "isValid" => "true",
            "errors" => array()
        );

        libxml_use_internal_errors(true);
        $xmlError = "";
        while($this->xml_reader->read()){
            if(!$this->xml_reader->isValid()){
                $isValid['isValid'] = "false";
                //$xmlError = libxml_get_last_error();
                foreach(libxml_get_errors() as $error) {
                    array_push($isValid['errors'],str_replace("\n","",$error->message));
                }

                throw new XMLNotValidException(join(",",$isValid['errors']),0,null);
            }
        }

        /*
        if(!empty($xmlError))
            Log::info("XMLSERRROR: ".print_r($xmlError,1));
            array_push($isValid['errors'],str_replace("\n","",$xmlError->message));
         */

        $this->xml_reader->close();

        if($json){
            return json_encode($isValid);
        }
        else{
            return $isValid['isValid'];
        }
    }


}