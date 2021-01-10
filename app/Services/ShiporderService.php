<?php

namespace App\Services;

use App\Models\Shiporder;
use App\Models\ShipItem;
use App\Repositories\ShiporderRepository;
use App\Jobs\BusXMLParserDataProcessor;
use App\Services\ShipItemService;
use App\Repositories\ShipItemRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ShiporderService {

    private $shiporderRepository;
    private $shipItemService;

    public function __construct(ShiporderRepository $shiporderRepository)
    {
        $this->shiporderRepository = $shiporderRepository;
        $this->shipItemService =  new ShipItemService(new ShipItemRepository);
    }

    public function store($filename, $data, $isAsyncUpload = false)
    {
        $success = false;
        if($isAsyncUpload) {
            $success = $this->storeAsync($data, $filename);
        } else {
            $success = $this->storeNonAsync(convertXMLDataTypeToArray($data));
        }
        return $success;
    }

    public function storeNonAsync($data) 
    {
        $success = false;
        foreach ($data as $shiporderData) {
            $shiporder = [
                'id' => $shiporderData['orderid'],
                'people_id' => $shiporderData['orderperson'],
                'shipto_name' => $shiporderData['shipto']['name'],
                'shipto_address' => $shiporderData['shipto']['address'],
                'shipto_city' => $shiporderData['shipto']['city'],
                'shipto_country' => $shiporderData['shipto']['country']
            ];
            
            $shiporderSaved = $this->shiporderRepository->store($shiporder);

            if(!$shiporderSaved || !$shiporderSaved->wasRecentlyCreated) {
                return false;
            }

            $items = $shiporderData['items'];
            
            if($shiporderSaved->wasRecentlyCreated && (is_array($items) || is_object($items))){
                $success = $this->shipItemService->storeItems($items, $shiporderSaved->id);
            } else {
                Log::error('Wrong format for items data');
            }
        }
        return $success;
    }

    function storeAsync($data, $fileName) 
    {
        $success = false;
        $folder = Config('constants.xml_paths.shiporder_xml_file_path');
        $success = $this->shiporderRepository->storeFile($data, $fileName);
        if($success){
            BusXMLParserDataProcessor::dispatch($folder.'/'.$fileName);
            $success = true;
        } else {
            Log::error('Can not store file to process asynchronously');
        }
        return $success;
    }

    public function getAll()
    {
        return $this->shiporderRepository->getAll();
    }

    public function getById($shiporderId)
    {
        $validator = Validator::make(['shiporder_id' => $shiporderId], ['shiporder_id' => 'numeric|required']);
        
        $data =  $this->shiporderRepository->getById($shiporderId);
        return ['data' => $data ?? '', 'message' => $validator->fails() ? $validator->errors() : '']; 
    }
}