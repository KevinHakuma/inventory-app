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
            $table->string('nama_aset');
            $table->string('kode_aset')->unique();
            $table->foreignId('kategori_id')->constrained('kategori');
            $table->foreignId('cabang_id')->constrained('cabang');
            $table->string('merek');
            $table->string('processor');
            $table->string('ram');
            $table->string('storage');
            $table->string('kondisi');
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
