<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'active',
        'create_date',
        'end_date'
    ];

    public function contract_details () : HasMany
    {
        return $this->hasMany(ContractDetail::class);
    }
}
