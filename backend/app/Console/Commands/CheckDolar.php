<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CheckDolar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dolar:check';
    protected $description = 'Consulta el valor del dólar y lo actualiza si ha cambiado';

    public function handle()
    {
        $response = Http::get('https://pydolarve.org/api/v1/dollar'); 
        $nuevoValor = $response->json()['monitors']['bcv']['price'];
        $valorGuardado = Cache::get('dolar', 50);

        if ($nuevoValor != $valorGuardado) {

            Cache::put('dolar', $nuevoValor, now()->addHours(5));

            $this->info("Dólar actualizado: $nuevoValor");
        } else {
            $this->info("El valor del dólar no ha cambiado.");
        }
    }
}
