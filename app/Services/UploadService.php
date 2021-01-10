<?php

namespace App\Services;

use App\Strategies\XMLStore\XMLStoreShiporder;
use App\Strategies\XMLStore\XMLStorePeople;
use App\XMLStore;

class UploadService
{
    private $xmlStoreShiporder;
    private $xmlStorePeople;

    const PERSON_TYPE = 'person';
    const SHIPORDER = 'shiporder';

    public function __construct(XMLStoreShiporder $xmlStoreShiporder, XMLStorePeople $xmlStorePeople) 
    {
        $this->xmlStoreShiporder = $xmlStoreShiporder;
        $this->xmlStorePeople = $xmlStorePeople;
    }

    public function dispatchData($filename, $data, $isAsyncUpload) {
        $xmlDataType = getXMLDataType($data);
        //is valid file ?
        if(!$xmlDataType){
            return false;
        }
        $service = $this->getXMLStoreStrategy($xmlDataType);
        return $service->store($filename, $data, $isAsyncUpload);
    }

    public function getXMLStoreStrategy($xmlDataType)
    {
        if($xmlDataType === self::PERSON_TYPE) {
            return $this->xmlStorePeople;

        } else if ($xmlDataType === self::SHIPORDER) {
            return $this->xmlStoreShiporder;
        }
    }
}