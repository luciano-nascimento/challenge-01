<?php

namespace App\Http\Repositories;

use App\Models\Shiporder;
use Illuminate\Support\Facades\Storage;
use Config;

class ShiporderRepository
{

    private $shiporder;

    function __construct(Shiporder $shiporder)
    {
        $this->shiporder = $shiporder;
    }

    function storeFile($data, $filename) 
    {
        $folder = Config('constants.xml_paths.shiporder_xml_file_path');
        return Storage::put($folder.'/'.$filename, $data);
    }

    function store(Shiporder $shiporder) 
    {
        return $shiporder->save();
    }
}