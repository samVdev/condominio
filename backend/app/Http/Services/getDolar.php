<?php
namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Settings;

class getDolar
{
    public static function getDollarRate()
    {
        $dolar = Cache::get('dolar');
        
        if (!$dolar) {
            //$dolar = Settings::where('key', 'dolar_rate')->value('value'); // Suponiendo que tienes una tabla 'Settings'
        }

        if (!$dolar) {
            $dolar = self::fetchAndSaveDollarRate();
        }

        return $dolar;
    }

    // Función para consultar la API y guardar el valor si es diferente
    private static function fetchAndSaveDollarRate()
    {
        $response = Http::get('https://pydolarve.org/api/v1/dollar');

        if ($response->failed()) {
            throw new \Exception("Error al obtener el valor del dólar");
        }

        $nuevoValor = $response->json()['monitors']['bcv']['price'];

        $valorGuardado = Cache::get('dolar');
        //$valorEnDB = Settings::where('key', 'dolar_rate')->value('value'); // Valor guardado en la base de datos

        if ($nuevoValor != $valorGuardado /*&& $nuevoValor != $valorEnDB*/) {
            Cache::put('dolar', $nuevoValor, now()->addHours(5));

           // Settings::updateOrCreate(
            //    ['key' => 'dolar_rate'],
           //     ['value' => $nuevoValor]
            //);
        }

        return $nuevoValor;
    }
}
