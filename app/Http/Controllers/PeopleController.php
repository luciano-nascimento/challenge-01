<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PeopleService;

class PeopleController extends Controller
{
    private $peopleService;

    public function __construct(PeopleService $peopleService)
    {
        $this->peopleService = $peopleService;
    }

    public function index()
    {
        $data = $this->peopleService->getAll();
        return response()->json(['data'=>$data], 200);
    }

    public function show($peopleId)
    {
        $data = $this->peopleService->getById($peopleId);
        return response()->json(['data'=>$data ?? ''], $data ? 200 : 400);
    }
}
