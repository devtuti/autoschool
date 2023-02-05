<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KursCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['kurs_id', 'kcat_name', 'slug', 'sub_id', 'status', 'created_at', 'updated_at'];

    protected $appends = [
        'parent'
    ];

    public function parent(){
        return $this->belongsTo(KursCategory::class, 'sub_id');
    }

    public function children(){
        return $this->hasMany(KursCategory::class, 'sub_id');
    }

    public function lesson()
    {
        return $this->hasMany(KursLesson::class,'cat_id');
    }

    public function kurs(){
        return $this->belongsTo(Kurs::class);
    }
}
