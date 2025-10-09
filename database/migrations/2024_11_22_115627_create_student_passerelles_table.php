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
        Schema::create('student_passerelles', function (Blueprint $table) {
            $table->id();
            $table->string('CNE')->nullable();
            $table->string('CIN')->nullable();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('nomar')->nullable();
            $table->string('prenomar')->nullable();
            $table->string('datenais')->nullable();
            $table->string('villenais')->nullable();
            $table->string('payschamp')->nullable();
            $table->string('villechamp')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('sexe')->nullable();
            $table->string('adresse')->nullable();
            $table->unsignedBigInteger('filiere')->nullable();
            $table->unsignedBigInteger('filiere_choix_1')->nullable();
            $table->unsignedBigInteger('filiere_choix_2')->nullable();
            $table->unsignedBigInteger('filiere_choix_3')->nullable();


            $table->string('serie')->nullable();
            $table->string('Anneebac')->nullable();
            $table->string('notebac')->nullable();
            $table->string('mention_bac')->nullable();


            $table->boolean('fonctionnaire',0)->nullable();
            $table->string('secteur')->nullable();
            $table->string('lieutravail')->nullable();
            $table->string('villetravail')->nullable();
            $table->string('nombreannee')->nullable();
            $table->string('poste')->nullable();


            //diplome
            $table->string('dernier_diplome_obtenu')->nullable(); // bac+2 ;bac+3; bac+4; bac+5
            $table->string('type_diplome_obtenu')->nullable(); //privee; public; autre
            $table->string('specialitediplome')->nullable();
            $table->string('ville_etablissement_diplome')->nullable();
            $table->string('date_optention_diplome')->nullable();


            //document
            $table->string('path_photo')->nullable();
            $table->string('path_cin')->nullable();
            $table->string('path_bac')->nullable();
            $table->string('path_diplomedeug')->nullable();
            $table->string('path_cv')->nullable();
            $table->string('path_attestation_non_emploi')->nullable();


            $table->unsignedBigInteger('etablissement_id')->nullable();

            $table->boolean('confirmation_student',0);

            $table->string('verif')->nullable();
            $table->text('motif')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_passerelles');
    }
};
