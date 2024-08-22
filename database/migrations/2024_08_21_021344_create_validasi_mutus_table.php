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
        Schema::create('validasi_mutus', function (Blueprint $table) {
            $table->id();
            $table->string('SertifikatId')->nullable();
            $table->string('Validasi1')->nullable();
            $table->string('Validasi2')->nullable();
            $table->string('Validasi3')->nullable();
            $table->string('Validasi4')->nullable();
            $table->string('Validasi5')->nullable();
            $table->string('Validasi6')->nullable();
            $table->string('Validasi7')->nullable();
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
        Schema::dropIfExists('validasi_mutus');
    }
};
