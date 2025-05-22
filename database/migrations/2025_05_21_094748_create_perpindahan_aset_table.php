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
        Schema::create('perpindahan_aset', function (Blueprint $table) {
            $table->id();

            // Ganti polymorphic dengan kategori + id aset spesifik
            $table->foreignId('kategori_id')->constrained('kategori')->cascadeOnDelete();
            $table->unsignedBigInteger('asset_id'); // ID dari tabel laptop, printer, dll

            $table->foreignId('cabang_asal_id')->nullable()->constrained('cabang')->nullOnDelete();
            $table->foreignId('cabang_tujuan_id')->constrained('cabang')->cascadeOnDelete();
            $table->string('user_baru')->nullable();

            $table->text('keterangan')->nullable();
            $table->timestamp('tanggal_pindah')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perpindahan_aset');
    }
};
