<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $fillable = [
        'first_name', 'last_name', 'gender', 'date_of_birthday', 'email'
    ];

}
