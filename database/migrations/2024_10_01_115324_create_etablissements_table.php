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
        Schema::create('etablissements', function (Blueprint $table) {
            $table->id();
            $table->string('nom_abrev');
            $table->string('nom');
            $table->text('description');
            $table->string('logo');
            $table->unsignedBigInteger('responsable_id')->nullable();
            $table->boolean('master_ouvert')->default(0);
            $table->boolean('passerelle_ouvert')->default(0);
            $table->boolean('multiple_choix_filiere_master')->default(0);//master
            $table->boolean('multiple_choix_filiere_passerelle')->default(0);//passerelle
            $table->boolean('show_cin_input_master')->default(0);
            $table->boolean('show_photo_input_master')->default(0);
            $table->boolean('show_cv_input_master')->default(0);
            $table->boolean('show_bac_input_master')->default(0);
            $table->boolean('show_licence_input_master')->default(0);
            $table->boolean('show_attestation_no_emploi_input_master')->default(0);
            $table->boolean('show_bac_input_passerelle')->default(0);
            $table->boolean('show_cin_input_passerelle')->default(0);
            $table->boolean('show_photo_input_passerelle')->default(0);
            $table->boolean('show_cv_input_passerelle')->default(0);
            $table->boolean('show_diplome_deug_input_passerelle')->default(0);
            $table->boolean('show_attestation_no_emploi_input_passerelle')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etablissements');
    }
};
