<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Services\BusService;
use Illuminate\Support\Str;


class BusController extends Controller
{
    
    private $busService;

    public function __construct(BusService $busService)
    {
        $this->busService = $busService;
    }
    /**
     * @OA\Get(
     *     path="/projects",
     *     @OA\Response(response="200", description="Display a listing of projects.")
     * )
     */
    public function store(Request $request) {
        
        $request->validate([
            'xmlfile' => 'required|mimes:application/xml,xml|max:10000'
        ]);

        $isAsyncUpload = false;  
        if($request->has('async')){
            $isAsyncUpload = true;
        }

        $fileName = (string) Str::uuid().'.'. $request->file('xmlfile')->extension();

        if ($request->hasFile('xmlfile')) {
            $xmlData = $request->file('xmlfile');
            $xmlDataContent = $xmlData->getContent();
            $this->busService->dispatchData($fileName, $xmlDataContent, $isAsyncUpload);            

            return back()
                ->with('success','upload completed !')
                ->with('file',$fileName);
        }

        return back()
                ->with('failed','invalid file');

        
    }
}