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
        Schema::create('sertifikat_fisik_fungsis', function (Blueprint $table) {
            $table->id();
            $table->string('SertifikatId')->nullable();
            $table->bigInteger('InstrumenId')->nullable();
            $table->enum('Parameter1', [0, 1])->nullable();
            $table->enum('Parameter2', [0, 1])->nullable();
            $table->enum('Parameter3', [0, 1])->nullable();
            $table->enum('Parameter4', [0, 1])->nullable();
            $table->enum('Parameter5', [0, 1])->nullable();
            $table->enum('Parameter6', [0, 1])->nullable();
            $table->enum('Parameter7', [0, 1])->nullable();
            $table->enum('Parameter8', [0, 1])->nullable();
            $table->enum('Parameter9', [0, 1])->nullable();
            $table->enum('Parameter10', [0, 1])->nullable();
            $table->enum('Parameter11', [0, 1])->nullable();
            $table->enum('Parameter12', [0, 1])->nullable();
            $table->enum('Parameter13', [0, 1])->nullable();
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
        Schema::dropIfExists('sertifikat_fisik_fungsis');
    }
};
