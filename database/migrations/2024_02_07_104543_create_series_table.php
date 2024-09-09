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
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string("titolo", 255);
            $table->string("regia", 255)->nullable();
            $table->integer("anno")->unsigned();
            $table->string("lingua", 255);
            $table->string("copertina_v", 255)->nullable();
            $table->string("copertina_o", 255)->nullable();
            $table->string("anteprima", 255)->nullable();
            $table->string("attori", 1000)->nullable();
            $table->string("trama", 10000)->nullable();
            $table->unsignedBigInteger("nation_id");
            $table->foreign("nation_id")->references('id')->on('nations');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
