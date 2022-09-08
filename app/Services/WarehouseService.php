<?php

namespace App\Services;

use App\Exceptions\Helpers\Helper;
use App\Http\Requests\CreateWarehouseRequest;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class WarehouseService {
    public function createWarehouse(CreateWarehouseRequest $request)
    {
        $responseMessage = '';
        $status = false;
        $responseData = null;
        $error = null;
        $validatedData =$request->validated();
        $user=  User::find(auth()->id());
        try{
            if($request->filled('id')){
                $message = "updated";
            }else $message="created";
            $validatedData['owner_id'] = $user->id;
            $wareCreated = Warehouse::updateOrCreate(
                [
                    'id'=>$request->id
                ],
                $validatedData
            );
            if($wareCreated){
                $status=true;
                $responseMessage="Warehouse $message";
            }else{
                $responseMessage="Warehouse could not be $message";
            }
            $responseData = $wareCreated;
        }catch(Throwable $ex){
          $responseMessage = 'There was an error';
          $error = LogUtils::errorLog($ex);
        }
        $res = AppUtils::formatJson($responseMessage, $status, $responseData);
        Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'WarehouseController@createWarehouse'));
        return $res;
    }

    public function  getWarehousesForAUser(Request $request)
    {
        $responseMessage = 'No data found';
        $status = false;
        $responseData = null;
        $error = null;
        $user =  User::find(auth()->id());
        $query =[];
        $request->validate(['per_page'=>['nullable',"integer"]]);
        try{
            $query = array_merge($query,["owner_id" => $user->id]);
            $warehouses = DB::table("warehouses")->where($query)
            ->leftJoin("regions","regions.id","warehouses.region_id")
            ->leftJoin("states","states.id","regions.state_id")
            ->select(
                "warehouses.*",
                "states.name as state_name",
                "regions.name as region_name"
            )->orderBy("warehouses.created_at","DESC");
            if($request->filled("per_page")){
                $warehouses  = $warehouses->paginate((int) $request->per_page);
            }else{ $warehouses=$warehouses->get();}
            if(count($warehouses) > 0){
                $responseMessage="Data found";
                $status=true;
            }
            $responseData=$warehouses;
        }catch(Throwable $ex){
            $responseMessage = 'There was an error';
            $error = LogUtils::errorLog($ex);
          }
          $res = AppUtils::formatJson($responseMessage, $status, $responseData);
          Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'WarehouseController@getWarehousesForAUser'));
          return $res;
    }
    public function  getAWarehouse(Request $request,$id)
    {
        $responseMessage = 'No data found';
        $status = false;
        $responseData = null;
        $error = null;
        $query =[];
        try{
            $query = array_merge($query,["warehouses.id" => $id]);
            $warehouses = DB::table("warehouses")->where($query)
            ->leftJoin("regions","regions.id","warehouses.region_id")
            ->leftJoin("states","states.id","regions.state_id")
            ->select(
                "warehouses.*",
                "states.name as state_name",
                "states.id as state_id",
                "regions.name as region_name",
                "regions.id as region_id"
            )->first();
            if($warehouses){
                $responseMessage="Data found";
                $status=true;
            }
            $responseData=$warehouses;
        }catch(Throwable $ex){
            $responseMessage = 'There was an error';
            $error = LogUtils::errorLog($ex);
          }
          $res = AppUtils::formatJson($responseMessage, $status, $responseData);
          Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'WarehouseController@getAWarehouse'));
          return $res;
    }

    public function  index(Request $request)
    {
        $responseMessage = 'No data found';
        $status = false;
        $responseData = null;
        $error = null;
        $request->validate(['per_page' => ['nullable','integer']]);
        $query=[];
        
        $warehouseStateColumnEqual = $request->validate([
            'name' => 'nullable|string',
        ]);

        $warehouseRegionColumnEqual = $request->validate([
            'name' => 'nullable|string',
        ]);
        
        $wareColLikeData = $request->validate([
            'warehouse_name' => 'nullable|string',
            'warehouse_location' => 'nullable|string',
            'warehouse_description' => 'nullable|string',
        ]);

        try{
            foreach ($warehouseStateColumnEqual as $safeTableCol => $userInput) {
                if ($userInput === null) continue;
                $query = array_merge($query, [
                    ['states.' . $safeTableCol, '=', $userInput]
                ]);
            }

            foreach ($warehouseRegionColumnEqual as $safeTableCol => $userInput) {
                if ($userInput === null) continue;
                $query = array_merge($query, [
                    ['regions.' . $safeTableCol, '=', $userInput]
                ]);
            }

            foreach ($wareColLikeData as $safeTableCol => $userInput) {

                if ($userInput === null) continue;
                $query = array_merge($query, [
                    ['warehouse.'.$safeTableCol, 'LIKE', '%' . $userInput . '%',]
                ]);
            }
            $warehouses = DB::table("warehouses")->where($query)
            ->leftJoin("regions","regions.id","warehouses.region_id")
            ->leftJoin("states","states.id","regions.state_id")
            ->select(
                "warehouses.*",
                "states.name as state_name",
                "regions.name as region_name"
            );
            if($request->filled("per_page")){
                $warehouses = $warehouses->paginate((int) $request->per_page);
            }else{
                $warehouses = $warehouses->get();
            }
            if(count($warehouses)  > 0){
                $status=true;
                $responseMessage="Data found";
            }
            $responseData = $warehouses;
        }catch(Throwable $ex){
            $responseMessage = 'There was an error';
            $error = LogUtils::errorLog($ex);
          }
          $res = AppUtils::formatJson($responseMessage, $status, $responseData);
          Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'WarehouseController@index'));
          return $res;
    }
}