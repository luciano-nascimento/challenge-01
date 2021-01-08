<?php

namespace App\Strategies\BusXMLParser;

use App\Http\Interfaces\BusXMLParserInterface;

class PersonBusXMLParser implements BusXMLParserInterface
{
    
    private $XMLData;
    
    function __construct($XMLData) {
        $this->$XMLData = $XMLData;
    }

    public function parseXml($xmldata) 
    {
        dd($xmldata);
        return '';
    }
}