<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harm extends Model
{
    use HasFactory;
    protected $fillable = [
        'sick',
        'billing_date',
        'billing_time',
        'description',
        'cost',
        'cost_submit',
        'harm_type_id',
        'user_id',
        'payment_status_id',
        'user_id',
        'customer_id',
        'depend_id',
        'contract_id',
        'doctor_approval',
        'franchise',
        'prepayment',
    ];

    public function harmtype()
    {
        return $this->belongsTo(HarmType::class, 'harm_type_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function depend()
    {
        return $this->belongsTo(Depend::class, 'depend_id');
    }
    public function paymentstatus()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }

    public function attachs (){
        return $this->morphMany(Attach::class,'attachable');
    }
}
