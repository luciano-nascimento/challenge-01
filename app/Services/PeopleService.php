<?php

namespace App\Services;

use App\Models\People;
use App\Models\Phone;
use App\Repositories\PeopleRepository;
use App\Jobs\BusXMLParserDataProcessor;
use App\Services\PhoneService;
use App\Repositories\PhoneRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class PeopleService {
    
    private $peopleRepository;
    private $phoneService;

    public function __construct(PeopleRepository $peopleRepository)
    {
        $this->peopleRepository = $peopleRepository;
        $this->phoneService = new PhoneService(new PhoneRepository);
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

    function storeNonAsync($data) 
    {
        $success = false;
        foreach ($data as $peopleData) {
            $people = [
                'id' => $peopleData['personid'],
                'name' => $peopleData['personname']
            ];
            
            $savedData = $this->peopleRepository->store($people);
            
            if(!$savedData->wasRecentlyCreated) {
                return false;
            }

            $phones = $peopleData['phones']['phone'];
            //dealing with data in array
            if ($savedData->wasRecentlyCreated && (is_array($phones) || is_object($phones))) {
                $success = $this->phoneService->storePhones($phones, $savedData->id);
            } else if($phones){
                $phone = [
                    'number' => $phones,
                    'people_id' => $savedData->id
                ];
                $success = $this->phoneService->store($phone);
            } else {
                Log::error('Wrong format for phone data');
            }
        }
        return $success;
    }

    function storeAsync($data, $fileName) 
    {
        $success = false;
        $folder = Config('constants.xml_paths.people_xml_file_path');
        $success = $this->peopleRepository->storeFile($data, $fileName);
        if($success){
            BusXMLParserDataProcessor::dispatch($folder.'/'.$fileName);
        } else {
            Log::error('Can not save xml file to process later, async process failed.');
        }
        return $success;
    }

    public function getAll()
    {
        return $this->peopleRepository->getAll();
    }

    public function getById($peopleId)
    {
        $validator = Validator::make(['shiporder_id' => $peopleId], ['shiporder_id' => 'numeric|required']);
        $this->peopleRepository->getById($peopleId);
        return ['data' => $data ?? '', 'message' => $validator->fails() ? $validator->errors() : ''];
    }
}