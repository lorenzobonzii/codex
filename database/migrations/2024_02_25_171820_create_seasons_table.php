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
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->string("titolo", 255)->nullable();;
            $table->integer("ordine")->unsigned();
            $table->integer("anno")->unsigned();
            $table->string("trama", 10000)->nullable();;
            $table->string("copertina", 150)->nullable();
            $table->unsignedBigInteger("serie_id");
            $table->foreign("serie_id")->references('id')->on('series');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seasons');
    }
};
