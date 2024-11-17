<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Service\BoletoService;

class ProcessBoletoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private array $rowData,
        private array $mapping,
        private array $boletos,
        private BoletoService $boletoService
    ){}

    public function handle()
    {
        try {
            $this->boletoService->gerarBoleto($this->rowData, $this->mapping, $this->boletos);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
