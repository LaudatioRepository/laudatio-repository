<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 09.10.18
 * Time: 09:38
 */

namespace App\Laudatio\Utils;

use App\Custom\ValidatorInterface;

class ValidatorService implements ValidatorInterface
{
    protected $xml;
    protected $schema;
    protected $rng_schema;
    protected $xml_reader;

    public function __construct($xmlFile)
    {
        $this->xml = $xmlFile;
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
     * @param $xml
     * @param bool $json
     * @return string
     */
    public function isWellFormed($xml,$json = true){
        $isValid = array(
            "isWellFormed" => "true",
            "errors" => array()
        );
        libxml_use_internal_errors(true);

        $sxe = simplexml_load_string(file_get_contents($xml));
        if ($sxe === false) {
            $isValid['isWellFormed'] = "false";

            foreach(libxml_get_errors() as $error) {
                array_push($isValid['errors'],str_replace("\n","",$error->message));
            }
        }
        if($json){
            return json_encode($isValid);
        }
        else{
            return $isValid['isWellFormed'];
        }

    }


    /**
     * @param $rngSchema
     * @param bool $json
     * @return mixed|string
     */
    public function isValidByRNG($rngSchema, $json = true){
        $isValid = array(
            "isValid" => "true",
            "errors" => array()
        );
        $this->setRelaxNGSchema($rngSchema);
        libxml_use_internal_errors(true);
        $xmlError = "";
        while($this->xml_reader->read()){
            if(!$this->xml_reader->isValid()){
                $isValid['isValid'] = "false";
                $xmlError = libxml_get_last_error();
            }
        }
        if(!empty($xmlError))
            array_push($isValid['errors'],str_replace("\n","",$xmlError->message));

        $this->xml_reader->close();

        if($json){
            return json_encode($isValid);
        }
        else{
            return $isValid['isValid'];
        }
    }


}