<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attach extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'url_path',
        'size',
        'mime',
        'attachable_type',
        'attachable_id',
    ];

    public function attachable (): MorphTo
    {
        return $this->morphTo();
    }
}
