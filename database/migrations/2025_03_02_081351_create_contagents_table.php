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
        Schema::create('contagents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->nullable()->index('idx_contagents_user_id');
            $table->string('inn', 12)->index('idx_contagents_inn');
            $table->string('name')->index('idx_contagents_name');
            $table->string('ogrn')->index('idx_contagents_ogrn');
            $table->text('address');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contagents');
    }
};
