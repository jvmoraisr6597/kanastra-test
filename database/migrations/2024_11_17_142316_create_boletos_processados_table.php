<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boletos_processados', function (Blueprint $table) {
            $table->id();
            $table->string('debtId')->unique();
            $table->string('governmentId');
            $table->string('email');
            $table->decimal('debtAmount', 10, 2);
            $table->date('debtDueDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boletos_processados');
    }
};
