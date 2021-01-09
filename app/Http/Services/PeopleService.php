<?php

namespace App\Http\Services;

use App\Models\People;
use App\Models\Phone;
use App\Http\Repositories\PeopleRepository;
use \App\Jobs\BusXMLParserDataProcessor;

class PeopleService {
    
    private $peopleRepository;

    public function __construct(PeopleRepository $peopleRepository)
    {
        $this->peopleRepository = $peopleRepository;
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

    function storeAsync($data, $fileName) 
    {
        $folder = Config('constants.xml_paths.people_xml_file_path');
        $success = $this->peopleRepository->storeFile($data, $fileName);
        if($success){
            BusXMLParserDataProcessor::dispatch($folder.'/'.$fileName);
        } else {
            //log
        }
    }
}