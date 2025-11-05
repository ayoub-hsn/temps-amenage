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
        Schema::create('bacheliers', function (Blueprint $table) {
            $table->id();
            $table->string('CNE')->nullable();
                $table->string('CIN')->nullable();
                $table->string('nom')->nullable();
                $table->string('prenom')->nullable();
                $table->string('nomar')->nullable();
                $table->string('prenomar')->nullable();
                $table->string('datenais')->nullable();
                $table->string('sexe')->nullable();
                $table->string('payschamp')->nullable();
                $table->string('villenais')->nullable();
                $table->string('villechamp')->nullable();
                $table->string('adresse')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->unsignedBigInteger('filiere')->nullable();
                $table->unsignedBigInteger('filiere_choix_1')->nullable();
                $table->unsignedBigInteger('filiere_choix_2')->nullable();
                $table->unsignedBigInteger('filiere_choix_3')->nullable();
                $table->string('serie')->nullable();
                $table->string('moyenne_bac')->nullable();
                $table->string('secteur')->nullable();
                $table->string('lieutravail')->nullable();
                $table->string('villetravail')->nullable();
                $table->string('poste')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->boolean('confirmation_student')->default(0);
                $table->unsignedBigInteger('etablissement_id')->nullable();
                $table->string('verif')->nullable();
                $table->text('motif')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bacheliers');
    }
};
