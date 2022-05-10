<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupUsers extends Model
{
    use HasFactory;
    protected $table = 'group_user';
    protected $fillable = ['user_id', 'group_id', 'group_admin', 'created_at', 'updated_at'];
}
