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

use App\Strategies\XMLStore\XMLStoreShiporder;
use App\Strategies\XMLStore\XMLStorePeople;

class XMLParserDataProcessor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $tries = 3;
    private $filePath;
    private $xmlStoreShiporder;
    private $xmlStorePeople;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        $this->xmlStoreShiporder = new XMLStoreShiporder(new ShiporderService(new ShiporderRepository(new Shiporder)));
        $this->xmlStorePeople = new XMLStorePeople(new PeopleService(new PeopleRepository (new People)));
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $uploadService = new UploadService($this->xmlStoreShiporder, $this->xmlStorePeople);
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
