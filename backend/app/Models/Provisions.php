<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provisions extends Model
{
    use HasFactory;

    protected $fillable = [
        'balance_id',
        'expense_id',
        'condominium_id',
        'facture_id',
        'mount',
        'paid',
        'number_month',
        'rest'
    ];

    public function balance()
    {
        return $this->belongsTo(ProvisionBalance::class);
    }

    public function expense()
    {
        return $this->belongsTo(Expenses::class);
    }


    public function condominium()
    {
        return $this->belongsTo(Condominium::class);
    }

    public function facture()
    {
        return $this->belongsTo(Factures::class);
    }
    
}