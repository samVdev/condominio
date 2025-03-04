<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'persona_id',
        'total_pagado',
        'gasto_id',
        'porcentaje_alicuota',
        'cedula',
        'referencia',
    ];

    // Relación con la persona
    public function persona()
    {
        return $this->belongsTo(Personas::class);
    }

    // Relación con el gasto
    public function gasto()
    {
        return $this->belongsTo(Expenses::class);
    }
}