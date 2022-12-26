<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment_like extends Model
{
    use HasFactory;
    protected $table = 'comment_like';

    protected $fillable = ['user_id', 'comment_id', 'created_at', 'updated_at'];

    public function comment_like()
    {
        return $this->belongsTo(Comment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
