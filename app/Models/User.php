<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        //'username',
        'phone_number',
        'birth_date',
        'picture_url',
        'username',
        //'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
//    protected $casts = [
//        'email_verified_at' => 'datetime',
//    ];
      use HasFactory;
    
    public function posts(){
        return $this->hasMany(Post::class);
    }
    //da li treba HASMANY(POSTS) ??????
    
    public function getJWTCustomClaims(){
        return [];
    }
    
    public function getJWTIdentifier(){
        return $this->getKey();
    }
    
    public function setPasswordAttribute($password){
        if(trim($password) === '')
            return;
        
        $this->attributes['password'] = Hash::make($password);
    }
}
