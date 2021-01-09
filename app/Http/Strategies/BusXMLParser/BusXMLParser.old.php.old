<?php

namespace App\Http\Strategies\BusXMLParser;

use App\Interfaces\BusXMLParserInterface;

class BusXMLParser
{
    private $dataType;

    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    }

    public function parseXML($data = null)
    {
        return $this->dataType->parseXML($data);
    }
}