<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\DatasetAPI;
use Validator;
use Illuminate\Http\Request; 

class DatasetController extends Controller
{

    private $apiService;
    
    public function __construct(DatasetAPI $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //
    }

    /**
     * Init.
     *
     * @return \Illuminate\Http\Response
     */
    public function init(Request $request)
    {
        $validator = Validator::make($request->all(), ['filename' => 'required']);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        try{
            $responseObj = $this->apiService->datasetInit('guest',request('filename'));
            
            if($responseObj->getStatusCode() == '200'){
                return $responseObj->getBody();
            }
        }catch(\Exception $e){
            return response()->json(['error'=>['code'=>$e->getCode(),'message'=>$e->getMessage()]], 401);
        }
    }

    /**
     * Status.
     *
     * @return \Illuminate\Http\Response
     */
    public function status($datasetId)
    {
        try{
            $responseObj = $this->apiService->datasetStatus($datasetId);
            
            if($responseObj->getStatusCode() == '200'){
                return $responseObj->getBody();
            }
        }catch(\Exception $e){
            return response()->json(['error'=>['code'=>$e->getCode(),'message'=>$e->getMessage()]], 401);
        }
    }
}
