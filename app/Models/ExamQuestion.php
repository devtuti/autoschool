<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ExamQuestion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'cat_id', 'question_name', 'slug', 'question', 'bal', 'staus', 'photo', 'created_at', 'updated_at'
    ];
    protected $dates = ['deleted_at'];

    public function car_category()
    {
        return $this->belongsTo(CarCategory::class);
    }

    public function exam_answer()
    {
        return $this->hasMany(ExamAnswer::class);
    }
}
