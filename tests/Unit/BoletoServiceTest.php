<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Service\BoletoService;
use App\Models\BoletoProcessado;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Mockery;

class BoletoServiceTest extends TestCase
{
    public function testGerarBoletoQuandoNaoProcessado()
    {
        Log::shouldReceive('channel->info')
            ->once()
            ->with("Boleto Gerado: 12345");

        $mockBoleto = Mockery::mock('alias:' . BoletoProcessado::class);
        $mockBoleto->shouldReceive('create')
            ->once()
            ->with([
                'debtId' => '12345',
                'governmentId' => '11111111111',
                'email' => 'email@example.com',
                'debtAmount' => 100.50,
                'debtDueDate' => '2024-12-01',
            ]);

        $data = [
            'debtId' => '12345',
            'governmentId' => '11111111111',
            'email' => 'email@example.com',
            'debtAmount' => 100.50,
            'debtDueDate' => '2024-12-01',
        ];
        $mapping = [
            'debtId' => 'debtId',
            'governmentId' => 'governmentId',
            'email' => 'email',
            'debtAmount' => 'debtAmount',
            'debtDueDate' => 'debtDueDate',
        ];
        $boletos = [];

        $boletoService = new BoletoService();
        $boletoService->gerarBoleto($data, $mapping, $boletos);
    }

    public function testGerarBoletoQuandoJaProcessado()
    {
        Log::shouldReceive('channel->info')
            ->once()
            ->with("Boleto já processado: 12345");

        $data = [
            'debtId' => '12345',
            'governmentId' => '11111111111',
            'email' => 'email@example.com',
            'debtAmount' => 100.50,
            'debtDueDate' => '2024-12-01',
        ];
        $mapping = [
            'debtId' => 'debtId',
            'governmentId' => 'governmentId',
            'email' => 'email',
            'debtAmount' => 'debtAmount',
            'debtDueDate' => 'debtDueDate',
        ];
        $boletos = ['12345'];

        $boletoService = new BoletoService();
        $boletoService->gerarBoleto($data, $mapping, $boletos);
    }

    public function testEnviarBoleto()
    {
        Log::shouldReceive('channel->info')
            ->once()
            ->with('Boleto Enviado: 12345');

        $data = [
            'debtId' => '12345',
        ];
        $mapping = [
            'debtId' => 'debtId',
        ];

        $boletoService = new BoletoService();
        $boletoService->enviarBoleto($data, $mapping);
    }
}


