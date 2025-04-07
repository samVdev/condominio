<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
    
class Factures extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'porcent_first_five_days',
        'total_dollars',
        'dollar_bcv',
        'number_month',
        'code'
    ];

    public function expenses()
    {
        return $this->hasMany(Expenses::class);
    }

    public function recibes()
    {
        return $this->hasMany(Receipt::class);
    }

    public static function getCode()
    {
        $dia = Carbon::now()->format('d'); // Día actual (ej: 27)
        $meses = [
            '01' => 'E', '02' => 'F', '03' => 'M', '04' => 'A', '05' => 'M', '06' => 'J',
            '07' => 'J', '08' => 'A', '09' => 'S', '10' => 'O', '11' => 'N', '12' => 'D'
        ];
        $mes = $meses[Carbon::now()->format('m')]; // Obtiene la letra del mes
        $prefijo = "{$dia}{$mes}-"; // Ejemplo: 27M-

        $ultimo = self::where('code', 'LIKE', "{$prefijo}%")->latest('id')->first();
        $numero = $ultimo ? ((int) substr($ultimo->codigo, -3)) + 1 : 1;

        return $prefijo . str_pad($numero, 3, '0', STR_PAD_LEFT);
    }
}
