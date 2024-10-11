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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('unit'); // Required
            $table->string('direktorat'); // Required
            $table->string('nama'); // Required
            $table->string('nip')->unique()->nullable(); // Make this nullable
            $table->string('golongan')->nullable(); // Nullable
            $table->string('jabatan_1'); // Required
            $table->string('jabatan_2')->nullable(); // Nullable
            $table->string('no_handphone')->nullable(); // Nullable
            $table->string('email')->nullable(); // Nullable
            $table->string('npwp')->unique()->nullable(); // Make this nullable
            $table->string('ktp')->unique()->nullable(); // Make this nullable
            $table->string('status')->nullable(); // Nullable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
