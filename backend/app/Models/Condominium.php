<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Condominium extends Model
{
    use HasFactory;

    protected $table = 'condominium';
    
    protected $hidden = [ 'created_at', 'updated_at' ];
    
    protected $fillable = [ 'Nombre', 'condominium_id', 'size', 'porcent_alicuota'];    


    public function personas()
    {
        return $this->hasMany(\App\Models\Personas::class);
    }
    
    public function condominio()
    {
        return $this->hasMany(Condominium::class);
    }
    
    public function Apartaments()
    {
        return $this->hasMany(Condominium::class)->with('Apartaments');
    }


    
}
