<?php
namespace App\Services;

use App\Exceptions\Helpers\Helper;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StateImport;
use App\Models\Region;
use App\Models\Role;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class SetupUtils{
    public static function createRoles(){
        $roles  = null;
        $rolesArray = Role::roles();
        foreach($rolesArray as $key => $role){
          $roles =  Role::updateOrCreate(
                ['name'=>$key],
                ['name'=>$key, 'assigned_name'=>$role]
            );
        }

        if($roles){
            return true;
        }
        return false;
    }

    public function createState()
    {
        $MDAs =null;
        $created =false;
        $rows = Excel::toArray(new StateImport ,storage_path('files/states.xlsx'));

        foreach($rows[0] as $row){
            if($row[0] ==null){//skip empty rows in the excel sheet
                continue;
            }
            
            $stateName = $row[0];
            $MDAs = State::updateOrCreate(
                ['name'=>$stateName]
                );
        } 
        if($MDAs !==null){
            $created=true;
        }
        return $created;
    }
    public function createRegion()
    {
        $region =null;
        $created =false;
        $rows = Excel::toArray(new StateImport ,storage_path('files/lgas.xlsx'));

        foreach($rows[0] as $row){
            if($row[0] ==null){//skip empty rows in the excel sheet
                continue;
            }
            
            $regionName = $row[0];
            $stateId = $row[1];
            $region = Region::updateOrCreate(
                ['name'=>$regionName,"state_id"=>$stateId]
                );
        } 
        if($region !==null){
            $created=true;
        }
        return $created;
    }
    
    public function getAllStates(Request $request)
    {
        $responseData=null;
        $responseMessage="no data found";
        $status=false;
        $error=null;
        try{
            $states = State::all();
            if($states){
                $status=true;
                $responseMessage="Data found";
            }
        $responseData = $states;
        }catch(Throwable $ex){
            $responseMessage = 'There was an error';
            $error = LogUtils::errorLog($ex);
        }
        $res = AppUtils::formatJson($responseMessage, $status, $responseData);
        Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'SetupController@getAllStates'));
        return $res;
    }
    public function getAllregions(Request $request)
    {
        $responseData=null;
        $responseMessage="no data found";
        $status=false;
        $error=null;
        $request->validate(["state_id"=>['nullable',"integer","exists:states,id"]]);
        $query = [];
        try{
            if($request->filled('state_id')){
                $query= array_merge($query,["regions.state_id"=>$request->state_id]);
            }
            $regions = DB::table("regions")->where($query)
                 ->leftJoin("states","states.id","regions.state_id")
                  ->select("regions.*","states.name as state_name")
                  ->get();
            if($regions){
                $status=true;
                $responseMessage="Data found";
            }
        $responseData = $regions;
        }catch(Throwable $ex){
            $responseMessage = 'There was an error';
            $error = LogUtils::errorLog($ex);
        }
        $res = AppUtils::formatJson($responseMessage, $status, $responseData);
        Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'SetupController@getAllregions'));
        return $res;
    }


}