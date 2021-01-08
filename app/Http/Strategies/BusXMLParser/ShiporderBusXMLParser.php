<?php

namespace App\Http\Strategies\BusXMLParser;

use App\Http\Interfaces\BusXMLParserInterface;

class ShiporderBusXMLParser implements BusXMLParserInterface
{
    private $xmldata = null;

    public function parseXml($xmldata = null) 
    {
        dd($xmldata);
        return '';
    }
}