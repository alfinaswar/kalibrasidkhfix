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
        Schema::create('serah_terimas', function (Blueprint $table) {
            $table->id();
            $table->string('KodeSt')->nullable();
            $table->string('CustomerId')->nullable();
            $table->datetime('TanggalDiterima')->nullable();
            $table->datetime('TanggalDiajukan')->nullable();
            $table->string('Status')->nullable();
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
        Schema::dropIfExists('serah_terimas');
    }
};
