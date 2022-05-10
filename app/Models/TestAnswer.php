<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestAnswer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'a_id', 't_q_id', 'answer', 'correct_answer', 'created_at', 'updated_at'
    ];

    public function test_question()
    {
        return $this->belongsTo(TestQuestion::class);
    }
}
