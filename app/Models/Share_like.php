<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share_like extends Model
{
    use HasFactory;
    protected $table = 'share_like';

    protected $fillable = ['user_id', 'share_id', 'created_at', 'updated_at'];

    public function share_like()
    {
        return $this->belongsTo(Share::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
