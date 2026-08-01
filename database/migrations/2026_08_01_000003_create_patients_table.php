<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_id')->constrained()->cascadeOnDelete();
            $table->string('full_name');
            $table->string('phone')->nullable();
            $table->date('birth_date')->nullable();
            $table->unsignedTinyInteger('age')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['clinic_id', 'full_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
