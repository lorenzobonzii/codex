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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("role_id");
            $table->foreign("role_id")->references('id')->on('roles');
            $table->unsignedBigInteger("person_id");
            $table->foreign("person_id")->references('id')->on('people');
            $table->unsignedBigInteger("state_id");
            $table->foreign("state_id")->references('id')->on('states');
            $table->string('user', 255);
            $table->integer('scadenza_sfida')->nullable();
            $table->string('secret_jwt', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
