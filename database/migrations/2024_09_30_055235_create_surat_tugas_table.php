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
            $table->string('jenis_pd');
            $table->string('pembayaran');
            $table->string('asal');
            $table->string('tujuan');
            $table->date('tanggal_kegiatan_mulai');
            $table->date('tanggal_kegiatan_selesai');
            $table->integer('lama_kegiatan');
            $table->string('maksut');
            $table->boolean('meeting_online')->default(false);
            $table->string('nama_kegiatan');
            $table->integer('jumlah_peserta');
            $table->text('dasar');
            $table->text('detail_jadwal');
            $table->string('penandatanganan');
            $table->string('lampiran')->nullable();
            $table->boolean('is_draft')->default(false);
            $table->text('catatan')->nullable();
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
