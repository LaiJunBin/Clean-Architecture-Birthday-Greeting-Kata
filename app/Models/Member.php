<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    const Male = 'Male';
    const Female = 'Female';

    const Genders = [self::Male, self::Female];

    protected $fillable = [
        'first_name', 'last_name', 'gender', 'date_of_birthday', 'email'
    ];

}
