<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class RestaurantOperator extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $guard = 'restaurant_operator';
    protected $fillable =['name','email','password','role_id'];
}
