<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test_User_Answer extends Model
{
    use HasFactory;
    protected $table = 'test_user_answers';
    protected $fillable = [
        'user_id', 'question_id', 'answer', 'created_at', 'updated_at'
    ];
}
