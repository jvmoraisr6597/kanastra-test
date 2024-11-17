<?php

namespace App\Jobs;

use App\Jobs\ProcessBoletoJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\BoletoProcessado;
use App\Service\BoletoService;

class CsvImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 1200;  // 20-minute timeout

    public function __construct(
        private string $filePath,
        private array $mapping
    ){}

    public function handle()
    {
        $fileStream = fopen($this->filePath, 'r');
        $skipHeader = true;
        $processedDebtIds = BoletoProcessado::pluck('debtId')->toArray();
        while ($row = fgetcsv($fileStream)) {
            if ($skipHeader) {
                $skipHeader = false;
                continue;
            }
            $boletoService = app(BoletoService::class);
            dispatch(new ProcessBoletoJob($row, $this->mapping, $processedDebtIds, $boletoService));
        }
        fclose($fileStream);
        unlink($this->filePath);
    }
}
