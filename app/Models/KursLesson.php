<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KursLesson extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'kurs_lessons';
    protected $fillable = ['cat_id', 'lesson_name', 'slug', 'les_video', 'content_text', 'photo', 'status', 'created_at', 'updated_at'];

    public function category()
    {
        return $this->belongsTo(KursCategory::class,'id');
    }

    
}
