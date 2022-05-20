<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['cat_name', 'slug', 'sub_id', 'status', 'created_at', 'updated_at'];

    protected $appends = [
        'parent'
    ];

    public function parent(){
        return $this->belongsTo(Category::class, 'sub_id');
    }

    public function children(){
        return $this->hasMany(Category::class, 'sub_id');
    }

    public function lesson()
    {
        return $this->hasMany(Lesson::class);
    }

    public function test_question()
    {
        return $this->hasMany(TestQuestion::class);
    }

    public function user_resultat()
    {
        return $this->hasMany(User_resultats::class);
    }
}
