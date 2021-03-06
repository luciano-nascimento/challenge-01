<?php

namespace App\Services;

use App\Models\Shiporder;
use App\Models\ShipItem;
use App\Repositories\ShiporderRepository;
use App\Jobs\XMLParserDataProcessor;
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
        $success = $this->validateXMLData(convertXMLDataTypeToArray($data));
        
        if($success){
            if($isAsyncUpload) {
                $success = $this->storeAsync($data, $filename);
            } else {
                $success = $this->storeNonAsync(convertXMLDataTypeToArray($data));
            }
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
            
            if(!$shiporderSaved) {
                return false;
            }

            $items = $shiporderData['items'];
            
            if($shiporderSaved && (is_array($items) || is_object($items))){
                //clear ship item data just in update case
                $this->shipItemService->deleteByShipOrderId($shiporderSaved->id);
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
            XMLParserDataProcessor::dispatch($folder.'/'.$fileName);
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

    public function validateXMLData($data) 
    {
        $valid = true;
        $ruleStringRequired = 'string|required';
        foreach ($data as $shiporderData) {
            $shiporderValidator = Validator::make(
                [
                    'id' => $shiporderData['orderid'],
                    'people_id' => $shiporderData['orderperson'],
                    'shipto_name' => $shiporderData['shipto']['name'],
                    'shipto_address' => $shiporderData['shipto']['address'],
                    'shipto_city' => $shiporderData['shipto']['city'],
                    'shipto_country' => $shiporderData['shipto']['country']
                ],
                [
                    'id' => 'numeric|required',
                    'people_id' => 'numeric|required',
                    'shipto_name' => $ruleStringRequired,
                    'shipto_address' => $ruleStringRequired,
                    'shipto_city' => $ruleStringRequired,
                    'shipto_country' => $ruleStringRequired
                ]
            );

            if($shiporderValidator->fails()){$valid=false;}
            $items = $shiporderData['items'];
            
            if (is_array($items) || is_object($items)) {

                //single data comes without index
                if(isset($items['item']['title'])){
                    $items = [0 => $items['item']];
                }
                else {
                    $items = $items['item'];
                }

                for($i=0;$i<count($items);$i++) {

                    $shipItemValidator = Validator::make(
                        [
                            'quantity' => $items[$i]['quantity'],
                            'price' => $items[$i]['price'],
                        ],
                        [
                            'quantity' => 'numeric|required',
                            'price' => 'numeric|required',
                        ]
                    );
                    if($shipItemValidator->fails()){$valid=false;}
                }
            }
        }
        return $valid;
    }    
}