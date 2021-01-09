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
            $success = $this->uploadService->dispatchData($fileName, $xmlDataContent, $isAsyncUpload);            
            $message = 'upload completed, but processing failed.';
            if($success){
                $message = 'upload completed !';
            }
            return back()
                ->with('success',$message)
                ->with('file',$fileName);
        }

        return back()
                ->with('failed','invalid file');

        
    }
}