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
        Schema::create('tabel_barang', function (Blueprint $table) {
            $table->id();
            $table->integer('id_users')->nullable();
            $table->string('kode_barang', 50)->nullable();
            $table->string('nama')->nullable();
            $table->integer('id_kategori')->nullable();
            $table->integer('id_rak')->nullable();
            $table->string('nama_pemilik')->nullable();
            $table->text('alamat')->nullable();
            $table->float('berat',12,2)->nullable();
            $table->smallInteger('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_barang');
    }
};
