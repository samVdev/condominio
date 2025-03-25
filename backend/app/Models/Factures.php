<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factures extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'porcent_first_five_days',
        'total_dollars',
        'dollar_bcv',
        'condominium_id'
    ];

    public function expenses()
    {
        return $this->hasMany(Expenses::class);
    }

    public function recibes()
    {
        return $this->hasMany(Receipt::class);
    }

    public function condominium()
    {
        return $this->belongsTo(Condominium::class);
    }
}
