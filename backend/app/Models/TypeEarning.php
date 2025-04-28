<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeEarning extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Relación con gastos
    public function earnings()
    {
        return $this->hasMany(Earnings::class);
    }
}