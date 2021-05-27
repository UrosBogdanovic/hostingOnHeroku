<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class CompanyData extends Model  {

    protected $fillable = [
        'username',
        'password',
        'company_name',
        'job_type',
        'company_phone_number',
        'domain',
        'user_id'
    ];
    protected $hidden = [
          'password',
        //'remember_token',
    ];

    use HasFactory;

    public function user() {
        return $this->hasOne(User::class);
    }
    
    public function setPasswordAttribute($password){
        if(trim($password) === '')
            return;
        
        $this->attributes['password'] = Hash::make($password);
    }

}
