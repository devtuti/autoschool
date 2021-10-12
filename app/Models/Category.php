<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
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
}
