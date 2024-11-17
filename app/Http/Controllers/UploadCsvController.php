<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Jobs\CsvImportJob;
class UploadCsvController extends Controller
{
    public function uploadCsv(Request $request)
    {
        $mapping = [
            'name' => 0,
            'governmentId' => 1,
            'email' => 2,
            'debtAmount' => 3,
            'debtDueDate' => 4,
            'debtId' => 5
        ];

        $file = $request->file('csv_file');
        $storedFile = $file->store('csv', 'public');

        dispatch(new CsvImportJob(storage_path('app/public/' . $storedFile), $mapping));

        return "CSV is processed by cron job...";
    }
}
