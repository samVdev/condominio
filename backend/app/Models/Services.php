<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_type',
    ];

    // Relación con gastos
    public function expenses()
    {
        return $this->hasMany(Expenses::class);
    }
}