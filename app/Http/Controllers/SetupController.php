<?php

namespace App\Http\Controllers;

use App\Exceptions\Helpers\Helper;
use App\Services\AppUtils;
use App\Services\LogUtils;
use App\Services\SetupUtils;
use Illuminate\Http\Request;
use Throwable;

class SetupController extends Controller
{
    public $setup ;
    public $message =[];
    public function __construct(SetupUtils $setup)
    {
        $this->setup = $setup;
    }
    public function setupSite(Request $request){
        $responseData=null;
        $message=[];
        $status=true;
        $responseMessage="";
        $error=null;
        try{
            if($this->setup->createRoles()){
            $message['Roles'] = "Roles created ";
            }
            else{ 
                $message['Roles'] = "Could not create Roles";
            };
            
            if($this->setup->createState()){
            $message['States'] = "States created ";
            }
            else{ 
                $message['States'] = "Could not create States";
            } 
            if($this->setup->createRegion()){
            $message['Regions'] = "Regions created ";
            }
            else{ 
                $message['Region'] = "Could not create Regions";
            } 
            $responseData = $message;
        }catch(Throwable $ex){
            $responseMessage = 'There was an error';
            $error = LogUtils::errorLog($ex);

        }
        $res = AppUtils::formatJson($responseMessage, $status, $responseData);
            Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'setuo#SetupController'));
        return $res;
    }

    public function getAllStates(Request  $request)
    {
        return $this->setup->getAllStates($request);
    }
    public function getAllRegions(Request  $request)
    {
        return $this->setup->getAllRegions($request);
    }
}