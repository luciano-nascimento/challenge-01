<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\People;
use App\Models\Phone;
use App\Models\Shiporder;
use App\Models\ShipItem;
use App\Http\Strategies\BusXMLParser\PersonBusXMLParser;
use App\Http\Strategies\BusXMLParser\ShiporderBusXMLParser;
use App\Http\Strategies\BusXMLParser\BusXMLParser;
use App\Http\Services\ShiporderService;
use App\Http\Services\PeopleService;

class BusController extends Controller
{
    protected $shiporderService;
    protected $peopleService;

    public function __construct(ShiporderService $shiporderService, PeopleService $peopleService)
    {
        $this->shiporderService = $shiporderService;
        $this->peopleService = $peopleService;
    }

    public function store(Request $request) {

        $request->validate([
            'xmlfile' => 'required|mimes:application/xml,xml|max:10000'
        ]);

        if ($request->hasFile('xmlfile')) {
            $fileName = (string) Str::uuid().'.'.$request->file('xmlfile')->extension();
            $upload = $request->xmlfile->storeAs('temp-bus-xml-files', $fileName);
            
            $xmlData = $request->file('xmlfile');
            $xmlDataContent = $xmlData->getContent();
            $dataType = getXMLDataType($xmlDataContent);
            $data = convertXMLDataTypeToArray($xmlDataContent);


            if($dataType === 'person') {
                $this->peopleService->store($data);
            } else if ($dataType === 'shiporder') {
                $this->shiporderService->store($data);
            }

            return back()
                ->with('success','upload completed !')
                ->with('file',$fileName);
        }

        
    }
}