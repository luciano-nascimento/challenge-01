<?php

namespace App\Services;

use App\Repositories\PhoneRepository;

class PhoneService
{
    private $phoneRepository;

    public function __construct(PhoneRepository $phoneRepository) {
        $this->phoneRepository = $phoneRepository;
    }

    public function store($phone)
    {
        return $this->phoneRepository->store($phone);
    }

    public function storePhones($phones, $peopleId)
    { 
        $success = true;
        foreach ($phones as $phoneNumber) {
            $phone = [
                'number' => $phoneNumber,
                'people_id' => $peopleId
            ];
            $this->store($phone) ? $success = true : $success = false;
        }
        return $success;
    }
}