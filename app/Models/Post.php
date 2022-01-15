<?php

namespace App\Models;

use App\Http\Traits\FileUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, FileUpload;
    protected $fillable =[
        'title',
        'author_id',
        'body',
        'status',
        'sub_category_id',
        'comment_counts',
        'user_id',
        'file_url',
        "file_small_size_url"
    ];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class,'sub_category_id','id');
    }
}
