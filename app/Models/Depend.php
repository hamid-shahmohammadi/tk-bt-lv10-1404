<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depend extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'family',
        'father',
        'sex',
        'national_code',
        'birth_certificate',
        'birth_date',
        'mobile',
        'phone',
        'user_id',
        'customer_id',
        'relation_id',
        'start_activity',
        'end_activity',
        'active',
    ];

    public function customer (){
        return $this->belongsTo(Customer::class);
    }
}
