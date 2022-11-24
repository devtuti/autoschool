<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KursQuestion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kurs_questions';
    protected $fillable = [
        'cat_id', 'question_name', 'slug', 'question', 'staus', 'correct_answer', 'photo', 'variant_count', 'created_at', 'updated_at'
    ];

    public function category()
    {
        return $this->belongsTo(KursCategory::class);
    }
}
