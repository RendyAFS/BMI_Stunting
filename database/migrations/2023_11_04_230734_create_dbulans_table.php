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
        Schema::create('dbulans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('danaks_id')->constrained();
            $table->string('umur_periksa');
            $table->string("bb_anak");
            $table->string("tb_anak");
            $table->string("st_anak");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbulans');
    }
};
