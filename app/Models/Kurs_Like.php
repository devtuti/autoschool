<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurs_Like extends Model
{
    use HasFactory;
    protected $table = 'kurs_liked';
    protected $fillable = ['user_id', 'kurs_id', 'created_at', 'updated_at'];

    public function course()
    {
        return $this->belongsTo(Kurs::class);
    }
}
