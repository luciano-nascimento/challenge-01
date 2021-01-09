<?php

namespace App\Services;

use App\Strategies\XMLStore\XMLStoreShiporder;
use App\Strategies\XMLStore\XMLStorePeople;
use App\XMLStore;

class UploadService
{
    private $xmlStoreShiporder;
    private $xmlStorePeople;

    function __construct(XMLStoreShiporder $xmlStoreShiporder, XMLStorePeople $xmlStorePeople) 
    {
        $this->xmlStoreShiporder = $xmlStoreShiporder;
        $this->xmlStorePeople = $xmlStorePeople;
    }

    public function dispatchData($filename, $data, $isAsyncUpload) {
        $xmlDataType = getXMLDataType($data);
        $service = $this->getXMLStoreStrategy($xmlDataType);
        return $service->store($filename, $data, $isAsyncUpload);
    }

    public function getXMLStoreStrategy($xmlDataType)
    {
        if($xmlDataType === 'person') {
            return $this->xmlStorePeople;

        } else if ($xmlDataType === 'shiporder') {
            return $this->xmlStoreShiporder;
        }
    }
}