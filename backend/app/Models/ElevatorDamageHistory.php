<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElevatorDamageHistory extends Model
{
    use HasFactory;

    protected $table = 'elevator_damage_histories';

    protected $fillable = [
        'elevator_id',
        'description',
        'status',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function elevator()
    {
        return $this->belongsTo(Elevator::class);
    }
}
