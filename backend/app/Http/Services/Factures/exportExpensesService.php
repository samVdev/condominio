<?php

namespace App\Http\Services\Factures;

use App\Http\Services\getDolar;
use App\Models\Expenses;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Condominium;
use App\Models\Earnings;
use App\Models\Factures;
use App\Models\Provisions;
use Carbon\Carbon;
use DateTime;

class exportExpensesService
{
    static public function index(Request $request)
    {
        try {
            $dolarBCV = getDolar::getDollarRate();

            $authUser = Auth::user();
            if (!$authUser) return response()->json(['message' => 'No permitido'], 403);

            $persona = Auth::user()->persona;

            $condominio = null;

            if ($persona->condominium_id) {
                $condominio = Condominium::select('Nombre', 'condominium_id', 'porcent_alicuota')->find($persona->condominium_id);
            }

            $facture = $request->input('facture');

            $factureDB = Factures::where('code', $facture)->first();

            $expensesDB = Expenses::join('services', 'service_id', 'services.id')
                ->leftJoin('condominium', 'expenses.condominium_id', 'condominium.id')
                ->where('facture_id', $factureDB->id)
                ->select(
                    'services.service_type',
                    'expenses.amount_dollars',
                    'expenses.dollar_value'
                );

            $earnigsDB = Earnings::join('type_earnings', 'type_id', 'type_earnings.id')
                ->where('facture_id', $factureDB->id)
                ->select(
                    'name',
                    'amount_dollars',
                    'dollar_value'
                );

            $provisionsDB = Provisions::join('provision_balances', 'balance_id', 'provision_balances.id')
                ->leftJoin('services', 'provision_balances.service_id', 'services.id')
                ->where('facture_id', $factureDB->id)
                ->select(
                    'service_type',
                    'mount',
                );

            $earnigs = $earnigsDB->get();
            $expenses = $expensesDB->get();
            $provisions = $provisionsDB->get();

            $totalBs = 0;
            $totalUsd = 0;

            $currentDate = Carbon::now();
            $createdAt = Carbon::parse($factureDB->created_at);

            $isWithinFirstFiveDays = $currentDate->diffInDays($createdAt) < 5;
            $isForMora = $currentDate->diffInDays($createdAt) > 31;

            $totalUsd += $factureDB->total_dollars;
            $totalBs += $factureDB->total_dollars * $dolarBCV;

            if ($condominio) {
                $alicuota = floatval($condominio->porcent_alicuota ?? 0);
                $totalUsd = (float) $totalUsd * ($alicuota / 100);
                $totalBs = (float) $totalBs * ($alicuota / 100);

                if ($isWithinFirstFiveDays) {
                    $discountPercentageDollar = floatval($factureDB->porcent_first_five_days);
                    $discountAmountDollar = $totalUsd * ($discountPercentageDollar / 100);
                    $totalUsd -= $discountAmountDollar;
                }

                if ($isForMora) {
                    $aumentAmountDollar = $totalUsd * (5 / 100);
                    $totalUsd += $aumentAmountDollar;
                }
            }

            //$totalBs = $totalUsd * $dolarBCV;

            $fechaFormateada = (new DateTime($factureDB->fecha))->format('d/m/Y');

            $condominiumData = [
                'name' => 'CONJUNTO RESIDENCIAL COMERCIAL YUTAJE',
                'address' => 'Urb. Los Dos Caminos entre 2da y 4ta Transversal',
                'alicuota' => $condominio ? $condominio->porcent_alicuota : 'Sin data',
                'month' => $fechaFormateada,
                'owner' => $persona->fullName
            ];

            $html = '
            <style>
                body { font-family: Arial, sans-serif; font-size: 10pt; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
                th, td { border: 1px solid #000; padding: 5px; }
                .header { background-color: #f2f2f2; font-weight: bold; }
                .text-right { text-align: right; }
                .text-center { text-align: center; }
                .no-border td { border: none; }
                .mt-10 { margin-top: 10px; }
                .border-top { border-top: 1px solid #000; }
                .border-bottom { border-bottom: 1px solid #000; }
            </style>
            
            <table class="border-top border-bottom">
                <tr>
                    <td></td>
                    <td width="50%">
                        <strong>' . $condominiumData['name'] . '</strong><br>
                        <small>' . $condominiumData['address'] . '</small>
                    </td>
                    <td width="15%">
                        <strong>ALICUOTA</strong>
                        <p>' . $condominiumData['alicuota'] . '</p>
                    </td>
                    <td width="15%">
                        <strong>RECIBO</strong>
                        <p>' . $condominiumData['month'] . '</p>
                    </td>
                </tr>
                <tr>
                    <td width="10%">
                        <strong>APTOLOCAL</strong><br>
                        <p>' . ($condominio ? $condominio->Nombre : 'Sin data') . '</p>
                    </td>
                    <td>
                        <strong>Propietario</strong><br>
                        <p>' . $condominiumData['owner'] . '</p>
                    </td>
                    <td>
                        <strong>NETO A PAGAR</strong><br>
                        <p>Bs. ' . number_format($totalBs, 2, ',', '.') . '</p>
                    </td>
                    <td>
                        <strong>NETO A PAGAR</strong><br>
                        <p>$ ' . number_format($totalUsd, 2, ',', '.') . '</p>
                    </td>
                </tr>
            </table>

            <table class="mt-10 text-center">
                <thead>
                    <tr class="header">
                        <th width="60%">DESCRIPCION DE LOS GASTOS</th>
                        <th width="20%">MONTO (Bs)</th>
                        <th width="20%">MONTO (USD)</th>
                    </tr>
                </thead>
                <tbody>';

            foreach ($expenses as $expense) {
                $montoBs = $expense->amount_dollars * $expense->dollar_value;

                $html .= '
                    <tr>
                        <td>' . $expense->service_type . '</td>
                        <td class="text-right">' . number_format($montoBs, 2, ',', '.') . '</td>
                        <td class="text-right">$ ' . number_format($expense->amount_dollars, 2, ',', '.') . '</td>
                    </tr>';
            }

            $html .= '</tbody>
            </table>
            

                <table class="mt-10 text-center">
                <thead>
                    <tr class="header">
                        <th width="60%">DESCRIPCION DE LOS INGRESOS</th>
                        <th width="20%">MONTO (Bs)</th>
                        <th width="20%">MONTO (USD)</th>
                    </tr>
                </thead>
                <tbody>
            ';

            foreach ($earnigs as $earnig) {
                $montoBsE = $earnig->amount_dollars * $earnig->dollar_value;

                $html .= '
                    <tr>
                        <td>' . $earnig->name . '</td>
                        <td class="text-right">' . number_format($montoBsE, 2, ',', '.') . '</td>
                        <td class="text-right">$ ' . number_format($earnig->amount_dollars, 2, ',', '.') . '</td>
                    </tr>';
            }

            $html .= '</tbody>
            </table>
            

                <table class="mt-10 text-center">
                <thead>
                    <tr class="header">
                        <th width="60%">DESCRIPCION DE LOS PROVISIONES</th>
                        <th width="20%">MONTO (Bs)</th>
                        <th width="20%">MONTO (USD)</th>
                    </tr>
                </thead>
                <tbody>
            ';

            foreach ($provisions as $provision) {
                $montoBsprov = $provision->mount;

                $html .= '
                    <tr>
                        <td>' . $provision->service_type . '</td>
                        <td class="text-right">' . number_format($montoBsprov, 2, ',', '.') . '</td>
                        <td class="text-right">$ ' . number_format($montoBsprov, 2, ',', '.') . '</td>
                    </tr>';
            }


            $html .= '
            </tbody>
        </table>

        <div class="mt-10">
            <p>Fecha de Vencimiento: _________________________</p>
            <p>Generado el: ' . now()->format('d/m/Y') . '</p>
        </div>';

            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return response($dompdf->output(), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="recibo_condominio_' . $condominiumData['month'] . '.pdf"');
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error al generar el recibo',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
