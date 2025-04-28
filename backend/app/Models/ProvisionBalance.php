<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProvisionBalance extends Model
{
    protected $table = 'provision_balances';

    protected $fillable = [
        'service_id',
        'current_balance',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Services::class);
    }
}
