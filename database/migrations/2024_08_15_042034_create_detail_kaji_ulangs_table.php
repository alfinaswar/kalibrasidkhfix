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
        Schema::create('detail_kaji_ulangs', function (Blueprint $table) {
            $table->id();
            $table->string('NoReg', 255)->nullable();
            $table->string('NamaAlat', 255)->nullable();
            $table->bigInteger('Qty')->nullable();
            $table->string('Metode1', 100)->nullable();
            $table->string('Metode2', 255)->nullable();
            $table->string('Status', 255)->nullable();
            $table->string('Kondisi', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_kaji_ulangs');
    }
};
