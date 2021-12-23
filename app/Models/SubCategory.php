<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable =[
        'sub_category_name',
        'category_id'
    ];

 public function posts()
 {
     return $this->hasMany(Post::class,'sub_category_id','id');
 }
}
