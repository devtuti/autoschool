<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = ['user_id', 'share_id', 'sub_comment_id', 'share_comment', 'share_photo', 'status', 'created_at', 'updated_at'];
}
