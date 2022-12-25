<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'share_id', 'comment_id', 'share_liked', 'comment_liked', 'created_at', 'updated_at'];

    public function share_like()
    {
        return $this->belongsTo(Share::class);
    }

    public function comment_like()
    {
        return $this->belongsTo(Comment::class);
    }
}
