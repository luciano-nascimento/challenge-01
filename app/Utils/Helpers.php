<?php

if (!function_exists('getXMLDataType')) {
    function getXMLDataType($xmldata) 
    {
        $xmlDataParsed = new \SimpleXMLElement($xmldata);
        $dataConverted = json_decode(json_encode($xmlDataParsed), true);
        return array_key_first($dataConverted);
    }
}

if (!function_exists('convertXMLDataTypeToArray')) {
    function convertXMLDataTypeToArray($xmldata) 
    {
        $xmlDataParsed = new \SimpleXMLElement($xmldata);
        $dataConverted = json_decode(json_encode($xmlDataParsed), true);
        return current($dataConverted);
    }
}



