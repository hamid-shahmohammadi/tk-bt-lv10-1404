<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsConfig extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'password',
        'url',
        'from',
        'happy_birthday',
        'happy_birthday_massage',
    ];
}
