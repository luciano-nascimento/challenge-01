<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ShiporderService;

class ShiporderController extends Controller
{
    
    private $shiporderService;

    public function __construct(ShiporderService $shiporderService) 
    {
        $this->shiporderService = $shiporderService;
    }

    public function index()
    {
        $data = $this->shiporderService->getAll();
        return response()->json(['data'=>$data], 200);
    }

    public function show($shiporderId)
    {
        $data = $this->shiporderService->getById($shiporderId);
        return response()->json($data, $data['data'] ? 200 : 400);
    }
}
