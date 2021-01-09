<?php

namespace App\Interfaces;

interface XMLStoreInterface 
{
    public function store($filename, $data, $isAsyncUpload);
}