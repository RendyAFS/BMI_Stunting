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
        Schema::create('dposyandus', function (Blueprint $table) {
            $table->id();
            $table->string("nama_posyandu");
            $table->string("lokasi_posyandu");
            $table->string("pkm");
            $table->string("kel");
            $table->string("rt");
            $table->string("rw");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dposyandus');
    }
};
