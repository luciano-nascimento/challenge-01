<?php

namespace App\Strategies\XMLStore;

use App\Interfaces\XMLStoreInterface;
use App\Services\PeopleService;

class XMLStorePeople implements XmlStoreInterface 
{

    private $peopleService;
    function __construct(PeopleService $peopleService) 
    {
        $this->peopleService = $peopleService;
    }
    public function store($filename, $data, $isAsyncUpload)
    {
        return $this->peopleService->store($filename, $data, $isAsyncUpload);
    }
    
}