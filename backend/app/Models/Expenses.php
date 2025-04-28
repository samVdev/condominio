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
        'facture_id',
        'amount_dollars',
        'dollar_value',
        'image',
        'mount_fund',
        'mount_prov'
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

    public function facture()
    {
        return $this->belongsTo(Factures::class);
    }

    public function provisions()
    {
        return $this->hasMany(Provisions::class, 'expense_id');
    }
    
}