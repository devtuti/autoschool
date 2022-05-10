<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestQuestion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'test_questions';
    protected $fillable = [
        'cat_id', 'question_name', 'slug', 'question', 'staus', 'correct_answer', 'photo', 'created_at', 'updated_at'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function test_answer()
    {
        return $this->hasMany(TestAnswer::class);
    }
}
