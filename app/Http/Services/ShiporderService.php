<?php

namespace App\Http\Services;

use App\Models\Shiporder;
use App\Models\ShipItem;
use App\Http\Repositories\ShiporderRepository;
use \App\Jobs\BusXMLParserDataProcessor;

class ShiporderService {

    private $shiporderRepository;

    public function __construct(ShiporderRepository $shiporderRepository)
    {
        $this->shiporderRepository = $shiporderRepository;
    }

    public function store($filename, $data, $isAsyncUpload = false)
    {
        if($isAsyncUpload) {
            $this->storeAsync($data, $filename);
        } else {
            $this->storeNonAsync(convertXMLDataTypeToArray($data));
        }
        return true;
    }

    function storeNonAsync($data) 
    {
        foreach ($data as $shiporderData) {
            $shiporder = new Shiporder;
            $shiporder->order_id = $shiporderData['orderid'];
            $shiporder->people_id = $shiporderData['orderperson'];
            $shiporder->shipto_name = $shiporderData['shipto']['name'];
            $shiporder->shipto_address = $shiporderData['shipto']['address'];
            $shiporder->shipto_city = $shiporderData['shipto']['city'];
            $shiporder->shipto_country = $shiporderData['shipto']['country'];

            $shiporderSaveSuccess = $this->shiporderRepository->store($shiporder);
        
            $items = $shiporderData['items'];
            
            if($shiporderSaveSuccess && (is_array($items) || is_object($items))){
                //single data comes without index
                if(isset($items['item']['title'])){
                    $itemsData = [0 => $items['item']];
                } else {
                    $itemsData = $items['item'];
                }

                for($i=0;$i<count($itemsData);$i++) {
                    $item = new ShipItem;                    
                    $item->shiporder_id = $shiporder->id;
                    $item->title = $itemsData[$i]["title"];
                    $item->note = $itemsData[$i]['note'];
                    $item->quantity = $itemsData[$i]['quantity'];
                    $item->price = $itemsData[$i]['price']; 
                    $item->save();
                }
            }
        }
    }

    function storeAsync($data, $fileName) 
    {
        $folder = Config('constants.xml_paths.shiporder_xml_file_path');
        $success = $this->shiporderRepository->storeFile($data, $fileName);
        if($success){
            BusXMLParserDataProcessor::dispatch($folder.'/'.$fileName);
        } else {
            //log
        }
    }
}