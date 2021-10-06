<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable =[
        'name',
        'restaurant_operator_id',
        'phone_1',
        'phone_2',
        'email_1',
        'email_2',
        'address_line_1',
        'address_line_2',
        'town_id',
        'photo',
        'description',
        'restaurant_guid'
    ];
}
