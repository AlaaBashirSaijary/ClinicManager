<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patient extends Model
{
    protected $fillable = [
        'clinic_id',
        'patient_number',
        'full_name',
        'gender',
        'phone',
        'address',
        'birth_date',
        'age',
        'diagnosis',
        'previous_medications',
        'current_medications',
        'allergies',
        'medical_history',
        'surgeries_history',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'age' => 'integer',
        ];
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function displayAge(): ?int
    {
        if ($this->age !== null) {
            return $this->age;
        }

        if ($this->birth_date) {
            return $this->birth_date->age;
        }

        return null;
    }

    public function genderLabel(): string
    {
        return match ($this->gender) {
            'male' => 'ذكر',
            'female' => 'أنثى',
            default => '—',
        };
    }

    public static function nextNumberForClinic(int $clinicId): string
    {
        $numbers = static::query()
            ->where('clinic_id', $clinicId)
            ->whereNotNull('patient_number')
            ->pluck('patient_number');

        $max = 0;

        foreach ($numbers as $number) {
            if (preg_match('/(\d+)/', (string) $number, $matches)) {
                $max = max($max, (int) $matches[1]);
            }
        }

        return (string) ($max + 1);
    }
}
