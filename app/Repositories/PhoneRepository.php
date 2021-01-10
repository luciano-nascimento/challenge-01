<?php

namespace App\Repositories;

use App\Models\Phone;

class PhoneRepository 
{
    public function store($phone) 
    {
        return Phone::create([
            'number' => $phone['number'],
            'people_id' => $phone['people_id']
        ]);       
    }
}