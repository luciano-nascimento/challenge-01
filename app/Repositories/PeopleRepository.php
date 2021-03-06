<?php

namespace App\Repositories;

use App\Models\People;
use Illuminate\Support\Facades\Storage;
use Config;

class PeopleRepository
{

    private $people;

    function __construct(People $people)
    {
        $this->people = $people;
    }

    function storeFile($data, $filename) 
    {
        $folder = Config('constants.xml_paths.people_xml_file_path');
        return Storage::put($folder.'/'.$filename, $data);
    }

    function store($people) 
    {
        return People::updateOrCreate(
            [
                'id' => $people['id']
            ],
            [
                'id' => $people['id'],
                'name' => $people['name'],
            ]
        );
    }

    public function getAll()
    {
        return People::with('phone')->get();
    }

    public function getById($peopleId)
    {
        return People::with('phone')->find($peopleId);
    }
}