<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Condominium;
use Illuminate\Support\Facades\Storage;

class ApartmentsTableSeeder extends Seeder
{
    public function run()
    {

        $torresNombres = ['A', 'B', 'C', 'D'];
        $torres = [];

        foreach ($torresNombres as $nombre) {
            $torres[$nombre] = Condominium::create([
                'Nombre' => 'Torre ' . $nombre,
                'condominium_id' => null,
                'size' => '',
                'porcent_alicuota' => '0'
            ]);
        }

        $path = base_path('/filesMasive/ALICUOTAS.csv');
        $file = fopen($path, 'r');

        fgetcsv($file, 1000, ';');

        while (($data = fgetcsv($file, 1000, ';')) !== false) {
            if (count($data) < 3) continue;

            [$torre, $apt, $alicuotRaw] = array_map('trim', $data);
            
            $torre = str_replace('Torre ', '', $torre);
            $alicuotRaw = str_replace(',', '.', $alicuotRaw);
            $alicuot = is_numeric($alicuotRaw) ? (float) $alicuotRaw : 0;

            if (!isset($torres[$torre])) continue;

            Condominium::create([
                'Nombre' => $apt,
                'condominium_id' => $torres[$torre]->id,
                'size' => '',
                'porcent_alicuota' => $alicuot
            ]);
        }

        fclose($file);
    }
}
