<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyData extends Model {

    protected $fillable = [
        'username',
        'password',
        'company_name',
        'job_type',
        'phone',
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

}
