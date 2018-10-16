<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 12.10.18
 * Time: 08:21
 */

namespace App\Exceptions;


use App\Custom\LaudatioExceptionInterface;

class XMLNotValidException extends \RuntimeException implements LaudatioExceptionInterface
{
    public function getMessage()
    {
        // TODO: Implement getMessage() method.
    }
}