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
        Schema::create('surat_tugas_pegawais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_tugas_id')->constrained('surat_tugas')->onDelete('cascade');
            $table->string('nama');
            $table->string('nip');
            $table->string('jabatan');
            $table->string('golongan');
            $table->string('status');
            $table->string('pelaksana');
            $table->string('keterangan');

            $table->date('tanggal_kegiatan_mulai');  // Kolom tanggal kegiatan mulai
            $table->date('tanggal_kegiatan_selesai'); // Kolom tanggal kegiatan selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_tugas_pegawais');
    }
};
