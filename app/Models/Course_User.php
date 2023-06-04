<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course_User extends Model
{
    use HasFactory;
    protected $table='user_kurs';
    protected $fillable = [
        'user_id','kurs_id','price','discount','payment'
    ];
}
