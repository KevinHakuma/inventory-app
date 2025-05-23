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
        Schema::create('laptops', function (Blueprint $table) {
            $table->id();
            $table->string('jenis')->nullable();
            $table->string('nama_aset')->nullable();
            $table->string('kode_aset')->unique()->nullable();
            $table->foreignId('kategori_id')->constrained('kategori')->nullable();
            $table->foreignId('cabang_id')->constrained('cabang')->nullable();
            $table->string('merek')->nullable();
            $table->string('processor')->nullable();
            $table->string('ram')->nullable();
            $table->string('storage')->nullable();
            $table->string('kondisi')->nullable();
            $table->timestamps();
            $table->softDeletes(); // ini wajib karena pakai --soft-deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptop');
    }
};
