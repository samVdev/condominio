<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'condominium_id',
        'amount_dollars',
        'dollar_value',
        'porcent_first_five_days',
    ];

    // Relación con servicios
    public function service()
    {
        return $this->belongsTo(Services::class);
    }

    // Relación con condominios
    public function condominium()
    {
        return $this->belongsTo(Condominium::class);
    }
}