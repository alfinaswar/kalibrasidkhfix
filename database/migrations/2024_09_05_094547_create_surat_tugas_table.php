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
        Schema::create('surat_tugas', function (Blueprint $table) {
            $table->id();
            $table->string('KodeSpk', 100)->nullable();
            $table->string('PoId')->nullable();
            $table->string('CustomerId')->nullable();
            $table->date('Tanggal')->nullable();
            $table->json('karyawanId')->nullable();
            $table->text('Deskripsi')->nullable();
            $table->enum('Approval', ['Y', 'N'])->default('N');
            $table->string('UserApproval')->nullable();
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
        Schema::dropIfExists('surat_tugas');
    }
};
