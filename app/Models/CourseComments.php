<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseComments extends Model
{
    use HasFactory;
    protected $table = 'course_comments';
    protected $fillable = [
        'user_id', 'kurs_id', 'comments', 'created_at', 'updated_at'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function course_comment_like()
    {
        return $this->hasMany(Course_Comment_Like::class,'comment_id');
    }
}
