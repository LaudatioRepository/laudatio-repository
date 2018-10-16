<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 09.10.18
 * Time: 09:36
 */

namespace App\Custom;


interface ValidatorInterface
{
    public function getXml();
    public function setXml($xml);
    public function getSchema();
    public function setSchema($schema);
    public function getRelaxNGSchema();
    public function setRelaxNGSchema($rng_schema);
    public function isWellFormed($json);
    public function isValidByRNG($json);

}