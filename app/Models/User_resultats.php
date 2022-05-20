<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_resultats extends Model
{
    use HasFactory;
    protected $table = 'user_resultats';
    protected $fillable = [
        'user_id', 'correct_count', 'correct_percent', 'created_at', 'updated_at'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
