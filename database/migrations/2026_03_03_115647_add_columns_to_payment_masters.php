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
        Schema::table('payment_masters', function (Blueprint $table) {
            $table->string('montant_detecter')->nullable();
            $table->boolean('verification')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_masters', function (Blueprint $table) {
            $table->dropColumn('montant_detecter');
            $table->dropColumn('verification');
        });
    }
};
