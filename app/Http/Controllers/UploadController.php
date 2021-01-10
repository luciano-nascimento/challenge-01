<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Services\UploadService;
use Illuminate\Support\Str;


class UploadController extends Controller
{
    
    private $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

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
            $success = $this->uploadService->dispatchData($fileName, $xmlDataContent, $isAsyncUpload);           

            if($isAsyncUpload && $success){
                return back()
                    ->with('success', 'File sent to process queue successfuly.');
            } else if($success){
                return back()
                    ->with('success', 'Upload completed successfuly.');
            } else {
                return back()
                    ->with('error', 'Upload failed. Data already exists or there is some inconsistency with data. Maybe you uploaded a shiporder before person file.');
            }
            
        } else {
            return back()
                ->with('failed','Invalid file.');
        }

        

        
    }
}