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
        Schema::create('filieres', function (Blueprint $table) {
            $table->id();
            $table->string('nom_abrv');
            $table->string('nom_complet');
            $table->text('description')->nullable();
            $table->string('document')->nullable();
            $table->unsignedBigInteger('etablissement_id')->nullable();
            $table->unsignedBigInteger('responsable_id')->nullable();
            $table->integer('type');//Master ou bien licence: 1=Master;2=Licence
            $table->boolean('active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filieres');
    }
};
