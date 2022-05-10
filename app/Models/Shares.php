<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shares extends Model
{
    use HasFactory;
    protected $table = 'shares';
    protected $fillable = ['user_id', 'content_text', 'photo', 'privacy', 'created_at', 'updated_at'];
}
