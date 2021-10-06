<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestaurantMenu extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
            'menu_name',
            'price',
            'promo_price',
            'menu_description',
            "menu_images",
            'menu_status',
            'restaurant_id',
            'promo_code',
            'menu_guid'
    ];
}
