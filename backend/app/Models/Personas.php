<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Personas extends Model
{
    use HasFactory;

    protected $keyType = 'int'; // Mantener ID como entero
    public $incrementing = true; // Permitir auto-incremento

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['uuid', 'fullName', 'phone'];

    // Generar automáticamente un UUID cuando se cree una persona
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function user()
    {
        return $this->hasOne(\App\Models\User::class, 'persona_id', 'id');
    }

    public function condominium()
    {
        return $this->belongsTo(\App\Models\Condominium::class, 'condominium_id');
    }
}
