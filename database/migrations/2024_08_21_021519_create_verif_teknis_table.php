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
        Schema::create('verif_teknis', function (Blueprint $table) {
            $table->id();
            $table->string('SertifikatId')->nullable();
            $table->string('Verifikasi1')->nullable();
            $table->string('Verifikasi2')->nullable();
            $table->string('Verifikasi3')->nullable();
            $table->string('Verifikasi4')->nullable();
            $table->string('Verifikasi5')->nullable();
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
        Schema::dropIfExists('verif_teknis');
    }
};
