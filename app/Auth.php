<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
    protected $table = 'users';
    public $timestamps = true;
    protected $fillable = [
        'username',
        'password'
    ];
    
}
