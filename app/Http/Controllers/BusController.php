<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Orchestra\Parser\Xml\Facade as XmlParser;

class BusController extends Controller
{
    public function store(Request $request) {

        $request->validate([
            'xmlfile' => 'required|mimes:application/xml,xml|max:10000'
        ]);

        if ($request->hasFile('xmlfile')) {
            $fileName = time().'.'.$request->file('xmlfile')->extension();
            $xmlData = $request->file('xmlfile');
            $xmlDataParsed = new \SimpleXMLElement($xmlData->getContent());

            foreach ($xmlDataParsed as $key => $data) {
                if($key === 'person') {
                    //todo
                } else if ($key === 'shiporder') {
                    //todo
                }
            }

            return back()
                ->with('success','upload completed !')
                ->with('file',$fileName);
        }

        
    }
}