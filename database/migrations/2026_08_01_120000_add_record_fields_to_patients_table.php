<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('patient_number', 50)->nullable()->after('clinic_id');
            $table->string('gender', 20)->nullable()->after('full_name');
            $table->string('address')->nullable()->after('phone');
            $table->text('previous_medications')->nullable()->after('diagnosis');
            $table->text('current_medications')->nullable()->after('previous_medications');
            $table->text('allergies')->nullable()->after('current_medications');
            $table->text('medical_history')->nullable()->after('allergies');
            $table->text('surgeries_history')->nullable()->after('medical_history');

            $table->unique(['clinic_id', 'patient_number']);
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropUnique(['clinic_id', 'patient_number']);
            $table->dropColumn([
                'patient_number',
                'gender',
                'address',
                'previous_medications',
                'current_medications',
                'allergies',
                'medical_history',
                'surgeries_history',
            ]);
        });
    }
};
