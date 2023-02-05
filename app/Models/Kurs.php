<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurs extends Model
{
    use HasFactory;
    protected $table = 'kurs';
    protected $fillable = ['admin_id', 'kurs_name', 'price', 'discount', 'kurs_content', 'status', 'created_at', 'updated_at'];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function kurscategory()
    {
        return $this->hasMany(KursCategory::class);
    }

    public function kurslike()
    {
        return $this->hasMany(Kurs_like::class);
    }


}
