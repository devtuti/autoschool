<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamAnswer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'e_q_id', 'answer', 'correct_answer', 'created_at', 'updated_at'
    ];

    public function exam_question()
    {
        return $this->belongsTo(ExamQuestion::class);
    }
}
