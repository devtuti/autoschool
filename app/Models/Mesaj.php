<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesaj extends Model
{
    use HasFactory;
    protected $table = 'mesaj';
    protected $fillable = ['wrote_id', 'to_id', 'sms', 'photo', 'status', 'created_at', 'updated_at'];
}
