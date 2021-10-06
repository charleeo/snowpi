<?php
namespace App\Services;

use App\Models\RestaurantOperator;
use App\Models\RestaurantRole;
use App\Models\Role;

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

    public function createOperatorRoles()
    {
        $roles = null;
       $data = RestaurantRole::Roles;
       foreach($data as $key=> $d){
         $roles=  RestaurantRole::updateOrCreate(['assigned_name'=>$key],['name'=>$d, 'assigned_name'=>$key]);
       }
       if($roles){
           return true;
       }
       return false;
    }
}