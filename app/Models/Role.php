<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name','assigned_name'];
    protected const Roles =['super_admin','logistic_manager','accountant','sales_manager'];
    protected const Role_name =['Super Admin', 'Logistic Manager','Account','Sales Manager'];

 public static function roles(){
     return array_combine(self::Roles,self::Role_name);
 }
}
