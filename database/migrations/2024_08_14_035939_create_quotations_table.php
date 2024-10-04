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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('KodeQuotation')->nullable();
            $table->string('SerahTerimaId')->nullable();
            $table->string('CustomerId')->nullable();
            $table->string('Perihal')->nullable();
            $table->string('Lampiran')->nullable();
            $table->string('TipeDiskon')->nullable();
            $table->string('Diskon')->nullable();
            $table->text('Header')->nullable();
            $table->text('Deskripsi')->nullable();
            $table->date('Tanggal')->nullable();
            $table->date('DueDate')->nullable();
            $table->string('Status')->nullable();
            $table->string('Ppn')->nullable();
            $table->string('SubTotal')->nullable();
            $table->string('Total')->nullable();
            $table->string('Po')->nullable();
            $table->string('Diteirma')->nullable();
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
        Schema::dropIfExists('quotations');
    }
};
