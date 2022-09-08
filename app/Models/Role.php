<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected const Roles =['super_admin','logistic_manager','accountant','sales_manager',"sales_help"];
    protected const Role_name =['Super Admin', 'Logistic Manager','Account','Sales Manager',"Sales Helper"];

 public static function roles(){
     return array_combine(self::Roles, self::Role_name);
    }
}


