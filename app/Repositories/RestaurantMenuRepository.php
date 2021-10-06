<?php

namespace App\Repositories;

use App\Exceptions\Helpers\Helper;
use App\Http\Requests\StoreRestaurantMenuRequest;
use App\Http\Requests\UpdateRestaurantMenuRequest;
use App\Models\RestaurantMenu;
use App\Services\AppUtils;
use App\Services\LogUtils;
use App\Services\TokenMaker;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Throwable;

class RestaurantMenuRepository {
    use ImageUpload;

   public function store(StoreRestaurantMenuRequest $request)
   {
    $status ='error';
    $responseData = null;
    $error = null;
    $message ='';
    $menu=null;
   
    try{
        $path = 'assets/images/restaurant_images/';
        $extensions = ['jpg','png','jpeg','gif'];
        $sizes = 204800;
        $images = $request->file('menu_images');
        
        $data  = $request->validated();
        $fileUpload = $this->uploadFiles($images,$extensions,$sizes,$path);
         if($fileUpload['error'] == null){
           $data['menu_images'] = $fileUpload['db'];
           $data['menu_guid'] = TokenMaker::makeMenuGUID();
           $menu = RestaurantMenu::create($data);
         }else{
             $error =$fileUpload['error'];//return if there is file upload error
             $res = AppUtils::formatJson($message, $status, $responseData);
            Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Restaurants Menu creation'));
            return $res;
         }

        if($menu){
            $message = "Menu Created";
            $responseData = $menu;
        }

        $status ="success";
    }catch(Throwable $ex){
       $message = 'There was an error';
       $error = LogUtils::errorLog($ex);
     }
     $res = AppUtils::formatJson($message, $status, $responseData);
        Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Restaurants Menu creation'));
        return $res;
   }

   public function update(UpdateRestaurantMenuRequest $request,$id)
   {
    $status ='error';
    $responseData = null;
    $error = null;
    $message ='';
    $menu=null;
   
    try{      
        $data  = $request->validated();
        return $data;
        $menu = RestaurantMenu::create($data);
        if($menu){
            $message = "Menu Created";
            $responseData = $menu;
        }
        $status ="success";
    }catch(Throwable $ex){
       $message = 'There was an error';
       $error = LogUtils::errorLog($ex);
     }
     $res = AppUtils::formatJson($message, $status, $responseData);
        Helper::write_log(LogUtils::getLogData($request, $error ? $error : $res, 'Restaurants Menu update'));
        return $res;
   }
     
}