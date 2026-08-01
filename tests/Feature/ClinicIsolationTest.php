<?php

namespace Tests\Feature;

use App\Models\Clinic;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClinicIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_nurse_only_sees_patients_from_her_clinic(): void
    {
        $aleppo = Clinic::query()->create(['name' => 'عيادة حلب', 'slug' => 'aleppo']);
        $jisr = Clinic::query()->create(['name' => 'عيادة جسر الشغور', 'slug' => 'jisr']);

        $aleppoNurse = User::factory()->create([
            'clinic_id' => $aleppo->id,
            'role' => 'nurse',
        ]);

        $aleppoPatient = Patient::query()->create([
            'clinic_id' => $aleppo->id,
            'patient_number' => '101',
            'full_name' => 'أحمد محمود',
            'diagnosis' => 'ماء أزرق',
        ]);

        $jisrPatient = Patient::query()->create([
            'clinic_id' => $jisr->id,
            'patient_number' => '201',
            'full_name' => 'أحمد علي',
            'diagnosis' => 'اعتلال شبكية',
        ]);

        $this->actingAs($aleppoNurse)
            ->get(route('patients.index', ['q' => 'أحمد']))
            ->assertOk()
            ->assertSee('أحمد محمود')
            ->assertDontSee('أحمد علي');

        $this->actingAs($aleppoNurse)
            ->get(route('patients.show', $jisrPatient))
            ->assertNotFound();

        $this->actingAs($aleppoNurse)
            ->get(route('patients.show', $aleppoPatient))
            ->assertOk()
            ->assertSee('ماء أزرق');
    }

    public function test_new_patient_is_saved_to_user_clinic_only(): void
    {
        $aleppo = Clinic::query()->create(['name' => 'عيادة حلب', 'slug' => 'aleppo']);
        $jisr = Clinic::query()->create(['name' => 'عيادة جسر الشغور', 'slug' => 'jisr']);

        $nurse = User::factory()->create([
            'clinic_id' => $jisr->id,
            'role' => 'nurse',
        ]);

        $this->actingAs($nurse)
            ->post(route('patients.store'), [
                'full_name' => 'سارة خالد',
                'diagnosis' => 'جفاف عين',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('patients', [
            'full_name' => 'سارة خالد',
            'clinic_id' => $jisr->id,
            'diagnosis' => 'جفاف عين',
        ]);

        $this->assertDatabaseMissing('patients', [
            'full_name' => 'سارة خالد',
            'clinic_id' => $aleppo->id,
        ]);
    }
}
