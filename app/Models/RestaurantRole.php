<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantRole extends Model
{
    use HasFactory;
    protected $fillable =['name','assigned_name'];
    public const Roles = [
        "super_admin" =>'Super Admin Operator',
         "editor"=>"Restaurant Editor",
         "cashier"=>'Restaurant Cashier',
         "sales_rep"=>"Sales Representative",
    ];

}
