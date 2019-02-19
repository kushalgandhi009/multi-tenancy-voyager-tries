<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\DatasetAPI;
use Validator;
use Illuminate\Http\Request;
use App\DatasetNotification;
use Illuminate\Support\Facades\Auth;

class DatasetController extends Controller
{

    private $apiService;
    const SUCCESS_STATUS = 200;
    const ERROR_STATUS = 400;
    
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
            return response()->json(['error'=>$validator->errors()], self::ERROR_STATUS);
        }
        try{
            $responseObj = $this->apiService->datasetInit('guest',request('filename'));
            
            if($responseObj->getStatusCode() == self::SUCCESS_STATUS){
                return $responseObj->getBody();
            }
        }catch(\Exception $e){
            return response()->json(['error'=>['code'=>$e->getCode(),'message'=>$e->getMessage()]], self::ERROR_STATUS);
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
            
            if($responseObj->getStatusCode() == self::SUCCESS_STATUS){
                return $responseObj->getBody();
            }
        }catch(\Exception $e){
            return response()->json(['error'=>['code'=>$e->getCode(),'message'=>$e->getMessage()]], self::ERROR_STATUS);
        }
    }
    
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function addNotificationEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'dataset_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        
        $user = Auth::user(); 
        $input = $request->all();
        $input['user_id'] = $user->id;
        try{
            $datasetNotification = DatasetNotification::create($input);
            $success['dataset_id'] =  $datasetNotification->dataset_id;
            return response()->json(['success'=> $success], self::SUCCESS_STATUS);
        }catch(\Exception $e){
            return response()->json(['error'=>['code'=>$e->getCode(),'message'=>$e->getMessage()]], self::ERROR_STATUS);
        }
    }
}
