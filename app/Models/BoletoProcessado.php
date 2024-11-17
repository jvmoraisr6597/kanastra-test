<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoletoProcessado extends Model
{
    protected $table = 'boletos_processados';

    protected $fillable = [
        'debtId',
        'governmentId',
        'email',
        'debtAmount',
        'debtDueDate',
    ];

    protected $casts = [
        'debtDueDate' => 'date',
    ];
}

