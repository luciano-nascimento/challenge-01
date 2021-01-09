<?php

namespace App\Http\Services;

use App\Http\Services\PeopleService;
use App\Http\Services\ShiporderService;

class BusService
{

    private $peopleService;
    private $shiporderService;

    function __construct(PeopleService $peopleService, ShiporderService $shiporderService) {
        $this->peopleService = $peopleService;
        $this->shiporderService = $shiporderService;
    }

    public function dispatchData($filename, $data, $isAsyncUpload) {
        $dataType = getXMLDataType($data);
        if($dataType === 'person') {
            $this->peopleService->store($filename, $data, $isAsyncUpload);
        } else if ($dataType === 'shiporder') {
            $this->shiporderService->store($filename, $data, $isAsyncUpload);
        }
    }
}