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
        Schema::create('subdistricts', function (Blueprint $table) {
            $table->bigIncrements('subdis_id'); // Primary key
            $table->string('subdis_name');
            $table->unsignedBigInteger('dis_id'); // Foreign key reference to districts
            $table->foreign('dis_id')->references('dis_id')->on('districts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subdistricts');
    }
};
