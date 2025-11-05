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
        Schema::table('student_masters', function (Blueprint $table) {
            $columns = [
                'CNE', 'CIN', 'nom', 'prenom', 'nomar', 'prenomar', 'datenais', 'villenais',
                'payschamp', 'villechamp', 'email', 'phone', 'sexe', 'adresse', 'filiere',
                'filiere_choix_1', 'filiere_choix_2', 'filiere_choix_3', 'serie', 'Anneebac',
                'fonctionnaire', 'secteur', 'lieutravail', 'villetravail', 'nombreannee',
                'poste', 'dernier_diplome_obtenu', 'type_diplome_obtenu', 'specialitediplome',
                'ville_etablissement_diplome', 'date_optention_diplome', 'path_photo', 'path_cin',
                'path_bac', 'path_licence', 'path_cv', 'path_attestation_non_emploi',
                'etablissement_id', 'confirmation_student', 'verif', 'motif', 'user_id',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('student_masters', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('student_masters', function (Blueprint $table) {
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

            $table->string('secteur')->nullable();
            $table->string('lieutravail')->nullable();
            $table->string('villetravail')->nullable();
            $table->string('poste')->nullable();

            $table->string('typelicence')->nullable();
            $table->string('etblsmtLp')->nullable();
            $table->string('specialitelp')->nullable();
            $table->string('date_obtention_LP')->nullable();
            $table->string('mentionlp')->nullable();
            $table->string('moyenne_licence')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('confirmation_student')->default(0);
            $table->unsignedBigInteger('etablissement_id')->nullable();
            $table->string('verif')->nullable();
            $table->text('motif')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_masters', function (Blueprint $table) {
            $columns = [
                'CNE', 'CIN', 'nom', 'prenom', 'nomar', 'prenomar', 'datenais', 'sexe',
                'payschamp', 'villenais', 'villechamp', 'adresse', 'email', 'phone',
                'filiere', 'filiere_choix_1', 'filiere_choix_2', 'filiere_choix_3',
                'serie', 'secteur', 'lieutravail', 'villetravail', 'poste', 'typelicence',
                'etblsmtLp', 'specialitelp', 'date_obtention_LP', 'mentionlp', 'moyenne_licence',
                'verif', 'motif', 'user_id', 'confirmation_student', 'etablissement_id'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('student_masters', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('student_masters', function (Blueprint $table) {
            // Only re-add if missing
            $reAdd = [
                'CNE', 'CIN', 'nom', 'prenom', 'nomar', 'prenomar', 'datenais', 'villenais',
                'payschamp', 'villechamp', 'email', 'phone', 'sexe', 'adresse', 'filiere',
                'filiere_choix_1', 'filiere_choix_2', 'filiere_choix_3', 'serie', 'Anneebac',
                'fonctionnaire', 'secteur', 'lieutravail', 'villetravail', 'nombreannee',
                'poste', 'dernier_diplome_obtenu', 'type_diplome_obtenu', 'specialitediplome',
                'ville_etablissement_diplome', 'date_optention_diplome', 'path_photo',
                'path_cin', 'path_bac', 'path_licence', 'path_cv', 'path_attestation_non_emploi',
                'etablissement_id', 'confirmation_student', 'verif', 'motif', 'user_id'
            ];

            foreach ($reAdd as $col) {
                if (!Schema::hasColumn('student_masters', $col)) {
                    $table->string($col)->nullable();
                }
            }
        });
    }
};
