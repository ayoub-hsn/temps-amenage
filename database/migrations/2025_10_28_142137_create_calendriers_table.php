<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('calendriers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etablissement_id')->nullable();
            $table->dateTime('date_debut_master')->nullable();
            $table->dateTime('date_fin_master')->nullable();
            $table->dateTime('date_debut_passerelle')->nullable();
            $table->dateTime('date_fin_passerelle')->nullable();
            $table->dateTime('date_debut_bachelier')->nullable();
            $table->dateTime('date_fin_bachelier')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendriers');
    }
};
