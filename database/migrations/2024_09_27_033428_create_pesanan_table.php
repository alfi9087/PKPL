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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_customer');
            $table->text('alamat');
            $table->string('no_tlp', 15);
            $table->integer('berat');
            $table->foreignId('id_paket')->constrained('paket')->onDelete('cascade');
            $table->enum('status', ['pending', 'proses', 'selesai']);
            $table->text('note')->nullable();
            $table->integer('total_harga');
            $table->date('tgl_masuk');
            $table->date('tgl_diambil')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
