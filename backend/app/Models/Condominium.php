<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Condominium extends Model
{
    use HasFactory;

    protected $table = 'condominium';
    
    protected $hidden = [ 'created_at', 'updated_at' ];
    
    protected $fillable = [ 'Nombre', 'condominium_id', 'size', 'porcent_alicuota'];    


    public function subCondominiums()
    {
        return $this->hasMany(Condominium::class, 'condominium_id');
    }

    public function parentCondominium()
    {
        return $this->belongsTo(Condominium::class, 'condominium_id');
    }
    
    public function persona()
    {
        return $this->hasMany(Personas::class, 'condominio_id');
    }
}
