<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = ['user_id', 'share_id', 'sub_comment_id', 'share_comment', 'share_photo', 'status', 'created_at', 'updated_at'];

   
    public function children(){
        return $this->hasMany(Comment::class, 'sub_comment_id')->with('children');
    }

    public function share(){
        return $this->belongsTo(Share::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function like_comment(){
        return $this->hasMany(Likes::class);
    }
}
