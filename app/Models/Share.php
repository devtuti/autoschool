<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;
    protected $table = 'shares';
    protected $fillable = ['user_id', 'content_text', 'photo', 'privacy', 'created_at', 'updated_at'];

    public function comment(){
        
        return $this->hasMany(Comment::class);
    }

  
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function like_share(){
        
        return $this->hasMany(Likes::class);
    }
}
