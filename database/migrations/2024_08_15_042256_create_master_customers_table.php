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
        Schema::create('master_customers', function (Blueprint $table) {
            $table->id();
            $table->string('KodeCust')->nullable();
            $table->string('Kategori')->nullable();
            $table->string('NoAspak')->nullable();
            $table->string('Name')->nullable();
            $table->string('Email')->nullable();
            $table->string('Telepon')->nullable();
            $table->string('Alamat')->nullable();
            $table->string('Deskripsi')->nullable();
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
        Schema::dropIfExists('master_customers');
    }
};
