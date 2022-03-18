<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable=['author_id','post_id','reply_count','comment_body','status'];
    public function post()
    {
        return $this->hasMany(Comment::class,'post_id');
    }
}