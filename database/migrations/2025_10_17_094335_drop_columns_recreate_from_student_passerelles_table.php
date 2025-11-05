<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_passerelles', function (Blueprint $table) {
            // ✅ Drop columns only if they exist
            $columnsToDrop = [
                'CNE', 'CIN', 'nom', 'prenom', 'nomar', 'prenomar', 'datenais', 'villenais',
                'payschamp', 'villechamp', 'email', 'phone', 'sexe', 'adresse', 'filiere',
                'filiere_choix_1', 'filiere_choix_2', 'filiere_choix_3', 'serie', 'Anneebac',
                'notebac', 'mention_bac', 'fonctionnaire', 'secteur', 'lieutravail', 'villetravail',
                'nombreannee', 'poste', 'dernier_diplome_obtenu', 'type_diplome_obtenu', 
                'specialitediplome', 'ville_etablissement_diplome', 'date_optention_diplome',
                'path_photo', 'path_cin', 'path_bac', 'path_diplomedeug', 'path_cv', 
                'path_attestation_non_emploi', 'etablissement_id', 'confirmation_student', 
                'verif', 'motif', 'user_id'
            ];

            foreach ($columnsToDrop as $col) {
                if (Schema::hasColumn('student_passerelles', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        // ✅ Add new columns only if they don’t exist
        Schema::table('student_passerelles', function (Blueprint $table) {
            if (!Schema::hasColumn('student_passerelles', 'CNE')) {
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
                $table->string('diplomedeug')->nullable();
                $table->string('specialitedeug')->nullable();
                $table->string('etblsmtdeug')->nullable();
                $table->string('date_obtention_deug')->nullable();
                $table->string('mentiondeug')->nullable();
                $table->string('moyenne_deug')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->boolean('confirmation_student')->default(0);
                $table->unsignedBigInteger('etablissement_id')->nullable();
                $table->string('verif')->nullable();
                $table->text('motif')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('student_passerelles', function (Blueprint $table) {
            $columns = [
                'CNE', 'CIN', 'nom', 'prenom', 'nomar', 'prenomar', 'datenais', 'sexe', 
                'payschamp', 'villenais', 'villechamp', 'adresse', 'email', 'phone', 'filiere',
                'filiere_choix_1', 'filiere_choix_2', 'filiere_choix_3', 'serie', 'secteur', 
                'lieutravail', 'villetravail', 'poste', 'diplomedeug', 'specialitedeug', 
                'etblsmtdeug', 'date_obtention_deug', 'mentiondeug', 'moyenne_deug', 'verif', 
                'motif', 'user_id', 'confirmation_student', 'etablissement_id'
            ];

            foreach ($columns as $col) {
                if (Schema::hasColumn('student_passerelles', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
