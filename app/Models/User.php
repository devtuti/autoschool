<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'teacher_id', 'status',
    ];

    public function comment(){
        //return $this->hasManyThrough(Comments::class, User::class);
        return $this->hasMany(Comment::class);
    }

    public function share(){
        return $this->hasMany(Share::class);
    }

    public function like(){
        return $this->hasMany(Share_like::class);
    }

    public function course_comment()
    {
        return $this->hasMany(CourseComments::class);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
