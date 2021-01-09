<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\UploadService;
use App\Services\PeopleService;
use App\Services\ShiporderService;
use App\Repositories\ShiporderRepository;
use App\Repositories\PeopleRepository;
use App\Models\Shiporder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\People;

class BusXMLParserDataProcessor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $tries = 3;
    private $filePath;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //should be dependency injection, but is causing max nesting level error, it deserves refac
        $uploadService = new UploadService(new PeopleService(new PeopleRepository (new People)), new ShiporderService(new ShiporderRepository(new Shiporder)));

        try {
            $data = Storage::get($this->filePath);
            if($data){
                $uploadService->dispatchData(null, $data, false);
                Storage::delete($this->filePath);
                //at this point is possible to send email to confirm a processing or whatever
            } else {
                Log::error('Can not retrieve data from storage.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }   
    }
}
