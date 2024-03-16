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
        Schema::create('closings', function (Blueprint $table) {
            $table->id();
            $table->string("provider")->nullable();
            $table->json("services")->nullable();
            $table->integer("meters")->nullable();
            $table->integer("total_meters")->nullable();
            $table->integer("total_do")->nullable();
            $table->integer("payments")->nullable();
            $table->integer("pending")->nullable();
            $table->date("date")->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('closings');
    }
};
