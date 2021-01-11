<?php

namespace App\Services;

use App\Repositories\ShipItemRepository;


class ShipItemService
{
    private $shipItemRepository;

    function __construct(ShipItemRepository $shipItemRepository)
    {
        $this->shipItemRepository = $shipItemRepository;
    }

    public function store($data)
    {
        return $this->shipItemRepository->store($data);
    }

    public function storeItems($items, $shiporderId){
        
        $success = false;

        //single data comes without index
        if(isset($items['item']['title'])){
            $itemsData = [0 => $items['item']];
        } else {
            $itemsData = $items['item'];
        }

        for($i=0;$i<count($itemsData);$i++) {

            $item = [
                'shiporder_id' => $shiporderId,
                'title' => $itemsData[$i]["title"],
                'note' => $itemsData[$i]['note'],
                'quantity' => $itemsData[$i]['quantity'],
                'price' => $itemsData[$i]['price'],
            ];                    
            
            $success =  $this->store($item) ? true : false;
        }
        return $success;
    }

    public function deleteByShipOrderId($shiporder)
    {
        return $this->shipItemRepository->deleteByShipOrderId($shiporder);
    }
}