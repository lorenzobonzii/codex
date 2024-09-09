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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("person_id");
            $table->foreign("person_id")->references('id')->on('people');
            $table->unsignedBigInteger("address_type_id");
            $table->foreign("address_type_id")->references('id')->on('address_types');
            $table->string("indirizzo", 255);
            $table->string("civico", 10);
            $table->unsignedBigInteger("municipality_id");
            $table->foreign("municipality_id")->references('id')->on('municipalities');
            $table->string("CAP", 5);
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
        Schema::dropIfExists('addresses');
    }
};
