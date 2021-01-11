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

    /**
     * @OA\Get(path="/api/people",tags={"People"}, summary="Return people data", security={{"default": {}}}, operationId="getAll", 
     *   @OA\Response(response=200,description="Success",content={
     *      @OA\MediaType(mediaType="application/json",
     *          @OA\Schema(
     *                     
     *                          @OA\Property(property="data", type="array", 
     *                              @OA\Items(
     *                                  @OA\Property(property="id", type="integer",  example=1),
     *                                  @OA\Property(property="name", type="string", example="John"),
     *                                  @OA\Property(property="phone", type="array", 
     *                                      @OA\Items(
     *                                          @OA\Property(property="number", type="string",  example="2345678"),
     *                                      )
     *                                  )
     *                              ),    
     *                          )
     *                   
     *                     ),
     *                     @OA\Property(property="message", 
     *                              type="string", example=""))
     *             
     *          }),
     *   @OA\Response(response=401,description="Unauthenticated")
     *)
    **/
    public function index()
    {
        $data = $this->peopleService->getAll();
        return response()->json(['data'=>$data], 200);
    }

    /**
     * @OA\Get(path="/api/people/{peopleId}",tags={"People"}, summary="Return people data by id", security={{"default": {}}}, operationId="getById",
     *   @OA\Parameter(name="peopleId", description=" people id", required=true, in="path", @OA\Schema(type="integer")), 
     *   @OA\Response(response=200,description="Success",content={
     *      @OA\MediaType(mediaType="application/json",
     *          @OA\Schema(
     *                     
     *                          @OA\Property(property="data", type="object",                     
     *                                  @OA\Property(property="id", type="integer",  example=1),
     *                                  @OA\Property(property="name", type="string", example="John"),
     *                                  @OA\Property(property="phone", type="array", 
     *                                      @OA\Items(
     *                                          @OA\Property(property="number", type="string",  example="7777777"),
     *                                      )
     *                                  )
     *                          ),
     *                          @OA\Property(property="message", 
     *                              type="string", example="")
     *          ),
     *     ) 
     *  }),
     *  @OA\Response(response=400, content={
     *      @OA\MediaType(mediaType="application/json",
     *          @OA\Schema(
     *                     
     *                          @OA\Property(property="data", type="string", example=""),
     *                          @OA\Property(property="message", 
     *                              type="object", 
     *                                  @OA\Property(property="shiporder_id", type="array", 
     *                                      @OA\Items(
     *                                          
     *                                      )
     *                                  ),
     *                          )
     *                     ),
     *    )
     *             
     *          } ,description="Bad parameter."),
     * @OA\Response(response=401,description="Unauthenticated")
     *)
    **/
    public function show($peopleId)
    {
        $data = $this->peopleService->getById($peopleId);
        return response()->json(['data'=>$data ?? ''], $data ? 200 : 400);
    }
}
