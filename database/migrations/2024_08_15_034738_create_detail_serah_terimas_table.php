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
        Schema::create('detail_serah_terimas', function (Blueprint $table) {
            $table->id();
            $table->string('NoReg', 255)->nullable();
            $table->string('NamaAlat', 255)->nullable();
            $table->bigInteger('Qty')->nullable();
            $table->string('Harga', 100)->nullable();
            $table->string('Diskon', 255)->nullable();
            $table->string('Amount', 255)->nullable();
            $table->string('Deskripsi', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_serah_terimas');
    }
};
