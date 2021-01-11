<?php

namespace App\Repositories;

use App\Models\Shiporder;
use Illuminate\Support\Facades\Storage;
use Config;
use App\Models\People;
use Illuminate\Support\Facades\Log;

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

    function store($data) 
    {
        
        $peopleExists = People::find($data['people_id']);
        if($peopleExists){
            return Shiporder::updateOrCreate(
                [
                    'id' => $data['id']
                ],
                [
                    'id' => $data['id'],
                    'people_id' => $data['people_id'],
                    'shipto_name' => $data['shipto_name'],
                    'shipto_address' => $data['shipto_address'],
                    'shipto_city' => $data['shipto_city'],
                    'shipto_country' => $data['shipto_country']
                ]
            );
        } else {
            Log::error('Can not store ship order because this person id do not exists.');
        }
        return false;
    }

    public function getAll()
    {
        return Shiporder::with('shipItem')->with('people')->get();
    }

    public function getById($shiporderId)
    {
        return Shiporder::with('shipItem')->with('people')->find($shiporderId);
    }
}