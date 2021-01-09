<?php

namespace App\Strategies\XMLStore;

use App\Interfaces\XMLStoreInterface;
use App\Services\ShiporderService;

class XMLStoreShiporder implements XmlStoreInterface 
{
    private $shiporderService;

    function __construct(ShiporderService $shiporderService) 
    {
        $this->shiporderService = $shiporderService;
    }

    public function store($filename, $data, $isAsyncUpload)
    {
        return $this->shiporderService->store($filename, $data, $isAsyncUpload);
    }
    
}