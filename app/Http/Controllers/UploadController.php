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

            $key = '';
            $message = '';
            if($isAsyncUpload && $success){
                $key = 'success';
                $message = 'File sent to process queue successfuly.';
            } else if($success){
                $key = 'success';
                $message = 'Upload completed successfuly.';
            } else {
                $key = 'error';
                $message = 'Upload failed. There is some inconsistency in this file or you uploaded a shiporder before person file.';
            }

            return back()
                    ->with($key, $message);
            
            
        } else {
            return back()
                ->with('failed','Invalid file.');
        }

        

        
    }
}