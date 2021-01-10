<?php

namespace App\Repositories;

use App\Models\ShipItem;

class ShipItemRepository
{
    public function store($data)
    {
        return ShipItem::create([
            'shiporder_id' => $data['shiporder_id'],
            'title' => $data["title"],
            'note' => $data['note'],
            'quantity' => $data['quantity'],
            'price' => $data['price'],
        ]);
    }
}