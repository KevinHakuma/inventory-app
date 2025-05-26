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
        Schema::create('printer', function (Blueprint $table) {
            $table->id();
            $table->string('jenis')->nullable();
            $table->string('nama_aset')->nullable();
            $table->string('kode_aset')->unique()->nullable();
            $table->string('serial_number')->nullable();
            $table->foreignId('kategori_id')->constrained('kategori')->nullable();
            $table->foreignId('cabang_id')->constrained('cabang')->nullable();
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
        Schema::dropIfExists('printer');
    }
};
