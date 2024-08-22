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
        Schema::create('serah_terima_alats', function (Blueprint $table) {
            $table->id();
            $table->string('NoReg', 255)->nullable();
            $table->string('Nama', 100)->nullable();
            $table->datetime('TanggalTerima')->nullable();
            $table->datetime('TanggalDiserahkan')->nullable();
            $table->integer('idUser')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serah_terima_alats');
    }
};
