<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;
    protected $fillable = ['teacher_id', 'group_name', 'status', 'created_at', 'updated_at'];

    public function admins()
    {
        return $this->belongsTo(Admin::class);
    }
}
