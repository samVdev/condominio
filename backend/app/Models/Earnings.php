<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earnings extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
        'condominium_id',
        'facture_id',
        'amount_dollars',
        'dollar_value',
        'image',
    ];

    // Relación con servicios
    public function typeEarning()
    {
        return $this->belongsTo(TypeEarning::class);
    }

    // Relación con condominios
    public function condominium()
    {
        return $this->belongsTo(Condominium::class);
    }

    public function facture()
    {
        return $this->belongsTo(Factures::class);
    }
    
}