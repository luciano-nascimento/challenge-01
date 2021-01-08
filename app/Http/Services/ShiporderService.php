<?php

namespace App\Http\Services;

use App\Models\Shiporder;
use App\Models\ShipItem;

class ShiporderService {

    private $shiporderRepository;

    // public function __construct(ShiporderRepository $shiporderRepository)
    // {
    //     $this->shiporderRepository = $shiporderRepository;
    // }

    public function store($data)
    {
        //bad big O needs refactory
        foreach ($data as $shiporderData) {
            $shiporder = new Shiporder;
            $orderId = $shiporderData['orderid'];
            $peopleId = $shiporderData['orderperson'];
            $shipName = $shiporderData['shipto']['name'];
            $shipAdress = $shiporderData['shipto']['address'];
            $shipCountry = $shiporderData['shipto']['country'];
            $shipCity = $shiporderData['shipto']['city'];
            $shiporder->order_id = $orderId;
            $shiporder->people_id = $peopleId;
            $shiporder->shipto_name = $shipName;
            $shiporder->shipto_address = $shipAdress;
            $shiporder->shipto_city = $shipCity;
            $shiporder->shipto_country = $shipCountry;
            
            $items = $shiporderData['items'];
           
            if($shiporder->save() && (is_array($items) || is_object($items))){
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

    
    
}