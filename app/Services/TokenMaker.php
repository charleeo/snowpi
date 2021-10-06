<?php

namespace App\Services;

use App\Models\Restaurant;
use App\Models\RestaurantMenu;

final class TokenMaker {
    public static final function randStr($length): string
    {
        $alphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' . bin2hex(random_bytes(24));
        $token = array();
    
        $alphaLength = strlen($alphabet) - 1;
    
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $token[] = $alphabet[$n];
        }
        return implode("", $token);
    }

    public static function makeRestaurantGUID(){
        $guid = "REST-";
        $guid = $guid.self::randStr(8);
        if(Restaurant::where(['restaurant_guid'=>$guid])->exists()){
          $guid =  self::makeRestaurantGUID();
        }
        return strtoupper($guid);
    }
    public static function makeMenuGUID(){
        $guid = "MENU-";
        $guid = $guid.self::randStr(8);
        if(RestaurantMenu::where(['menu_guid'=>$guid])->exists()){
          $guid =  self::makeMenuGUID();
        }
        return  strtoupper($guid);
    }

}