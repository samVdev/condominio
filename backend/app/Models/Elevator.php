<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Elevator extends Model
{
    use HasFactory;

    protected $table = 'elevators';

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['condominium_id', 'number', 'operative'];

    public function parentCondominium()
    {
        return $this->belongsTo(Condominium::class, 'condominium_id');
    }

    public function damageHistories()
    {
        return $this->hasMany(ElevatorDamageHistory::class);
    }
}
