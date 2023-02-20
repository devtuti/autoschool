<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course_Comment_Like extends Model
{
    use HasFactory;
    protected $table = 'course_comment_like';
    protected $fillable = ['user_id', 'comment_id', 'created_at', 'updated_at'];

    public function course_comment()
    {
        return $this->belongsTo(CourseComments::class,'id');
    }
}
