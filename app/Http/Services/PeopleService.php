<?php

namespace App\Http\Services;

use App\Models\People;
use App\Models\Phone;

class PeopleService {
    
    private $peopleRepository;

    // public function __construct(PeopleRepository $peopleRepository)
    // {
    //     $this->peopleRepository = $peopleRepository;
    // }

    public function store($data)
    {
        foreach ($data as $peopleData) {
            $people_id = $peopleData['personid'];
            $name = $peopleData['personname'];
            $people = new People;
            $people->people_id = $people_id;
            $people->name = $name;

            $phones = $peopleData['phones']['phone'];

            if ($people->save() && (is_array($phones) || is_object($phones))) {
                foreach ($phones as $key => $phoneNumber) {
                    $phone = new Phone;
                    $phone->number = $phoneNumber;
                    $phone->people_id = $people->id;
                    $phone->save();
                }
            } else if($phones){
                $phone = new Phone;
                $phone->number = $phones;
                $phone->people_id = $people->id;
                $phone->save();
            } else {
                //todo logs
            }
        }
    }
}