<?php

namespace App\Service;

use Illuminate\Support\Facades\Log;
use App\Models\BoletoProcessado;
use Illuminate\Support\Facades\DB;

class BoletoService {

    /**
     * @param array $data
     * @return void
     */
    public function gerarBoleto($data, $mapping, $boletos): void
    {
        DB::transaction(function () use ($data, $mapping, $boletos) {
            if (!in_array($data[$mapping['debtId']], $boletos)) {
                BoletoProcessado::create([
                    'debtId' => $data[$mapping['debtId']],
                    'governmentId' => $data[$mapping['governmentId']],
                    'email' => $data[$mapping['email']],
                    'debtAmount' => $data[$mapping['debtAmount']],
                    'debtDueDate' => $data[$mapping['debtDueDate']],
                ]);

                Log::channel('boletos_log')->info("Boleto Gerado: {$data[$mapping['debtId']]}");
            } else {
                Log::channel('boletos_log')->info("Boleto já processado: {$data[$mapping['debtId']]}");
            }
        });
    }

    public function enviarBoleto($data, $mapping): void 
    {
        Log::channel('boletos_log')->info('Boleto Enviado: ' . $data[$mapping['debtId']]);
    }
}