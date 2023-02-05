<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course_user_resultats extends Model
{
    use HasFactory;
    protected $table = 'course_user_resultats';
    protected $fillable = [
        'user_id', 'correct_count', 'correct_percent', 'created_at', 'updated_at'
    ];
}
