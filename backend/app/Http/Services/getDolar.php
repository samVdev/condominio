<?php
namespace App\Http\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Config;

class GetDolar
{
    private const CACHE_KEY = 'dolar';
    private const CACHE_TIME = 5;
    private const CONFIG_ID = 1;
    private const API_URL = 'https://pydolarve.org/api/v1/dollar';

    public static function getDollarRate()
    {
        $dolar = Cache::get(self::CACHE_KEY);

        if (!$dolar) {
            $config = Config::find(self::CONFIG_ID);
            $dolar = $config ? $config->dolar : null;

            if ($dolar) {
                Cache::put(self::CACHE_KEY, $dolar, now()->addHours(self::CACHE_TIME));
            }
        }

        return $dolar;
    }

    // La funcion de aca abajo se usa para cuando se va actualizar el dolar, es decir. Cada 5h el sistema pedira
    // a la api el dolar, si este ha cambiado lo colocara en la cache y la db

    public static function updateDollarRate()
    {
        try {
            $response = Http::get(self::API_URL);

            if ($response->failed()) {
                throw new \Exception("Error al obtener el valor del dólar desde la API.");
            }

            $nuevoValor = $response->json()['monitors']['bcv']['price'];
            $config = Config::find(self::CONFIG_ID);

            if ($config && $nuevoValor != $config->dolar) {
                $config->update(['dolar' => $nuevoValor]);
                Cache::put(self::CACHE_KEY, $nuevoValor, now()->addHours(self::CACHE_TIME));
            }

            return $nuevoValor;
        } catch (\Exception $e) {
            return null;
        }
    }
}
