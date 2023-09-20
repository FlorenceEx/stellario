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
        Schema::create('stars_managers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger("star_id");
            $table->bigInteger("manager_id");

            //clefs étrangères
            $table->foreign('star_id')->references('id')->on('stars')->onDelete('cascade');
            $table->foreign('manager_id')->references('id')->on('managers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stars_managers');
    }
};
