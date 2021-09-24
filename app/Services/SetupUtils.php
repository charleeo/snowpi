<?php
namespace App\Services;

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
}