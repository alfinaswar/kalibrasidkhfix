<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengukuran_listriks', function (Blueprint $table) {
            $table->id();
            $table->string('SertifikatId')->nullable();
            $table->bigInteger('InstrumenId')->nullable();
            $table->enum('tipe', ['B', 'BF', 'CF'])->nullable();
            $table->enum('kelas', ['I', 'II', 'IP'])->nullable();
            $table->string('Parameter1')->nullable();
            $table->string('Parameter2')->nullable();
            $table->string('Parameter3')->nullable();
            $table->string('Parameter4')->nullable();
            $table->string('Parameter5')->nullable();
            $table->string('Parameter6')->nullable();
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
        Schema::dropIfExists('pengukuran_listriks');
    }
};
