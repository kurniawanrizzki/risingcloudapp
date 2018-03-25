<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    public $timestamps = true;
    protected $fillable = [
        'username',
        'password',
        'address',
        'phone',
        'role'
    ];
    
}
