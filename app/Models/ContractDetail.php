<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'contract_id',
        'harm_type_id',
        'cost',
        'repeat',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
    public function harmtype()
    {
        return $this->belongsTo(HarmType::class, 'harm_type_id');
    }
}
