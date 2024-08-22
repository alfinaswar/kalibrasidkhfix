<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pos', function (Blueprint $table) {
            $table->id();
            $table->string('KodePo')->nullable();
            $table->string('QuotationId')->nullable();
            $table->string('CustomerId')->nullable();
            $table->string('TanggalPo')->nullable();
            $table->string('TipeDiskon')->nullable();
            $table->string('Diskon')->nullable();
            $table->date('DueDate')->nullable();
            $table->string('Status')->nullable();
            $table->string('Ppn')->nullable();
            $table->string('Subtotal')->nullable();
            $table->string('Total')->nullable();
            $table->string('Deskripsi')->nullable();
            $table->string('Disetujui')->nullable();
            $table->string('idUser')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos');
    }
};
