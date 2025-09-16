<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens,HasFactory;
    protected $fillable = [
        'name',
        'family',
        'father',
        'email',
        'username',
        'personnel_code',
        'national_code',
        'birth_certificate',
        'birth_date',
        'organization_id',
        'contract_id',
        'mobile',
        'phone',
        'sheba',
        'account_number',
        'booklet_number',
        'sex',
        'password',
        'start_activity',
        'end_activity',
        'active',
        'user_id'
    ];

    public function depends (): HasMany
    {
        return $this->hasMany(Depend::class);
    }

    public function organization (): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
