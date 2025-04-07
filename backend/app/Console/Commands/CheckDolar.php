<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Services\getDolar;


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
        $nuevoValor = getDolar::updateDollarRate();
        
        if ($nuevoValor) {
            $this->info("Dólar actualizado a: $nuevoValor");
        } else {
            $this->error("No se pudo actualizar el valor del dólar.");
        }
    }
}
