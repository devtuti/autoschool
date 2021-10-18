<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['cat_id', 'lesson_name', 'slug', 'content_text', 'photo', 'status', 'created_at', 'updated_at'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
