<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['cat_name', 'slug', 'sub_id', 'status', 'created_at', 'updated_at'];

    protected $appends = [
        'parent'
    ];

    public function parent(){
        return $this->belongsTo(CarCategory::class, 'sub_id');
    }

    public function children(){
        return $this->hasMany(CarCategory::class, 'sub_id');
    }

    public function exam_question()
    {
        return $this->hasMany(ExamQuestion::class);
    }
}
