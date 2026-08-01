<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClinicSeeder extends Seeder
{
    public function run(): void
    {
        $aleppo = Clinic::query()->updateOrCreate(
            ['slug' => 'aleppo'],
            ['name' => 'عيادة حلب']
        );

        $jisr = Clinic::query()->updateOrCreate(
            ['slug' => 'jisr-al-shughur'],
            ['name' => 'عيادة جسر الشغور']
        );

        User::query()->updateOrCreate(
            ['email' => 'nurse.aleppo@clinic.test'],
            [
                'name' => 'ممرضة حلب',
                'password' => Hash::make('password'),
                'clinic_id' => $aleppo->id,
                'role' => 'nurse',
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'nurse.jisr@clinic.test'],
            [
                'name' => 'ممرضة جسر الشغور',
                'password' => Hash::make('password'),
                'clinic_id' => $jisr->id,
                'role' => 'nurse',
            ]
        );

        Patient::query()->updateOrCreate(
            [
                'clinic_id' => $aleppo->id,
                'patient_number' => '101',
            ],
            [
                'full_name' => 'أحمد محمود',
                'gender' => 'male',
                'phone' => '0944000001',
                'address' => 'حلب',
                'age' => 45,
                'diagnosis' => 'ماء أزرق في العين اليسرى',
                'previous_medications' => 'قطرة تيمولول',
                'current_medications' => 'قطرة خافضة للضغط العيني',
                'allergies' => 'لا يوجد',
                'medical_history' => 'ضغط دم',
                'surgeries_history' => null,
                'notes' => 'يحتاج متابعة شهرية',
            ]
        );

        Patient::query()->updateOrCreate(
            [
                'clinic_id' => $jisr->id,
                'patient_number' => '201',
            ],
            [
                'full_name' => 'فاطمة الحسن',
                'gender' => 'female',
                'phone' => '0933000002',
                'address' => 'جسر الشغور',
                'age' => 52,
                'diagnosis' => 'اعتلال شبكية سكري',
                'previous_medications' => 'أنسولين',
                'current_medications' => 'قطرة مرطبة + أدوية سكري',
                'allergies' => 'حساسية من البنسلين',
                'medical_history' => 'سكري منذ 10 سنوات',
                'surgeries_history' => 'لا يوجد',
                'notes' => 'مراجعة بعد أسبوعين',
            ]
        );
    }
}
