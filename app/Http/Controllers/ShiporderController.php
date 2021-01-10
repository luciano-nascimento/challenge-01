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

    /**
     * @OA\Get(path="/api/shiporder",tags={"Shiporder"}, summary="Return shiporder data",operationId="getAll", 
     *   @OA\Response(response=200,description="Success",content={
     *      @OA\MediaType(mediaType="application/json",
     *          @OA\Schema(
     *                     
     *                          @OA\Property(property="data", type="array", 
     *                              @OA\Items(
     *                                  @OA\Property(property="id", type="integer",  example=1),
     *                                  @OA\Property(property="people_id", type="string", example="1"),
     *                                  @OA\Property(property="shipto_name", type="string", example="John"),
     *                                  @OA\Property(property="shipto_address", type="string", example="stree x"),
     *                                  @OA\Property(property="shipto_city", type="string", example="John"),
     *                                  @OA\Property(property="shipto_country", type="string", example="John"),
     *                                  @OA\Property(property="ship_item", type="array", 
     *                                      @OA\Items(
     *                                          @OA\Property(property="id", type="string",  example="1"),
     *                                          @OA\Property(property="shiporder_id", type="string",  example="1"),
     *                                          @OA\Property(property="title", type="string", example="tile"),
     *                                          @OA\Property(property="note", type="string", example="note"),
     *                                          @OA\Property(property="quantity", type="integer",  example="2345678"),
     *                                          @OA\Property(property="price", type="decimal",  example="10.1"),
     *                                      )
     *                                  ),
     *                                  @OA\Property(property="people", type="object",
     *                                      @OA\Property(property="id", type="integer",  example=1),
     *                                      @OA\Property(property="name", type="integer",  example=1),
     *                                  )    
     *                              ),
     *                          )
     *                   
     *                     ),
     *      )
     *             
     *   }),
     *   @OA\Response(response=401,description="Unauthenticated")
     *)
    **/
    public function index()
    {
        $data = $this->shiporderService->getAll();
        return response()->json(['data'=>$data], 200);
    }

    /**
     * @OA\Get(path="/api/shiporder/{shiporderId}",tags={"Shiporder"}, summary="Return shiporder data by id",operationId="getById",
     *   @OA\Parameter(name="shiporderId", description=" shiporder id", required=true, in="path", @OA\Schema(type="integer")), 
     *   @OA\Response(response=200,description="Success",content={
     *      @OA\MediaType(mediaType="application/json",
     *          @OA\Schema(
     *                     
     *                          @OA\Property(property="data", type="object", 
     *                              
     *                                  @OA\Property(property="id", type="integer",  example=1),
     *                                  @OA\Property(property="people_id", type="string", example="1"),
     *                                  @OA\Property(property="shipto_name", type="string", example="John"),
     *                                  @OA\Property(property="shipto_address", type="string", example="stree x"),
     *                                  @OA\Property(property="shipto_city", type="string", example="John"),
     *                                  @OA\Property(property="shipto_country", type="string", example="John"),
     *                                  @OA\Property(property="ship_item", type="array", 
     *                                      @OA\Items(
     *                                          @OA\Property(property="id", type="string",  example="1"),
     *                                          @OA\Property(property="shiporder_id", type="string",  example="1"),
     *                                          @OA\Property(property="title", type="string", example="tile"),
     *                                          @OA\Property(property="note", type="string", example="note"),
     *                                          @OA\Property(property="quantity", type="integer",  example="2345678"),
     *                                          @OA\Property(property="price", type="decimal",  example="10.1"),
     *                                      )
     *                                  ),
     *                                  @OA\Property(property="people", type="object",
     *                                      @OA\Property(property="id", type="integer",  example=1),
     *                                      @OA\Property(property="name", type="integer",  example=1),
     *                                  )
     *                          ),
     *                          @OA\Property(property="message", 
     *                              type="string", example="")
     *                     ),
     *    )
     *             
     *          }),
     *   @OA\Response(response=400, content={
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
     *   @OA\Response(response=401,description="Unauthenticated")
     *)
    **/
    public function show($shiporderId)
    {
        $data = $this->shiporderService->getById($shiporderId);
        return response()->json($data, $data['data'] ? 200 : 400);
    }
}
