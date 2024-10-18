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
            $table->unsignedBigInteger('surat_tugas_id');
            $table->unsignedBigInteger('pegawai_pd_id');
            $table->timestamps();

            $table->foreign('surat_tugas_id')->references('id')->on('surat_tugas')->onDelete('cascade');
            $table->foreign('pegawai_pd_id')->references('id')->on('pegawai_pds')->onDelete('cascade');
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
