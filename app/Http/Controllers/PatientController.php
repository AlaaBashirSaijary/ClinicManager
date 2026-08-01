<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PatientController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim((string) $request->get('q', ''));

        $patients = collect();

        if ($query !== '') {
            $patients = Patient::query()
                ->where('clinic_id', $request->user()->clinic_id)
                ->where(function ($builder) use ($query) {
                    $builder
                        ->where('full_name', 'like', '%'.$query.'%')
                        ->orWhere('patient_number', 'like', '%'.$query.'%')
                        ->orWhere('phone', 'like', '%'.$query.'%');
                })
                ->orderBy('full_name')
                ->limit(50)
                ->get();
        }

        return view('patients.index', [
            'q' => $query,
            'patients' => $patients,
            'searched' => $query !== '',
        ]);
    }

    public function create(Request $request): View
    {
        return view('patients.create', [
            'suggestedNumber' => Patient::nextNumberForClinic((int) $request->user()->clinic_id),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['clinic_id'] = $request->user()->clinic_id;

        if (blank($data['patient_number'] ?? null)) {
            $data['patient_number'] = Patient::nextNumberForClinic((int) $request->user()->clinic_id);
        }

        $patient = Patient::create($data);

        return redirect()
            ->route('patients.show', $patient)
            ->with('success', 'تم حفظ إضبارة المريض بنجاح.');
    }

    public function show(Request $request, Patient $patient): View
    {
        $this->authorizeClinic($request, $patient);

        $patient->load('clinic');

        return view('patients.show', compact('patient'));
    }

    public function edit(Request $request, Patient $patient): View
    {
        $this->authorizeClinic($request, $patient);

        return view('patients.edit', [
            'patient' => $patient,
            'suggestedNumber' => null,
        ]);
    }

    public function update(Request $request, Patient $patient): RedirectResponse
    {
        $this->authorizeClinic($request, $patient);

        $patient->update($this->validated($request, $patient));

        return redirect()
            ->route('patients.show', $patient)
            ->with('success', 'تم تحديث إضبارة المريض.');
    }

    private function validated(Request $request, ?Patient $patient = null): array
    {
        $clinicId = (int) $request->user()->clinic_id;

        return $request->validate([
            'patient_number' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('patients', 'patient_number')
                    ->where(fn ($query) => $query->where('clinic_id', $clinicId))
                    ->ignore($patient?->id),
            ],
            'full_name' => ['required', 'string', 'max:255'],
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'phone' => ['nullable', 'string', 'max:40'],
            'address' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date', 'before_or_equal:today'],
            'age' => ['nullable', 'integer', 'min:0', 'max:120'],
            'diagnosis' => ['nullable', 'string', 'max:5000'],
            'previous_medications' => ['nullable', 'string', 'max:5000'],
            'current_medications' => ['nullable', 'string', 'max:5000'],
            'allergies' => ['nullable', 'string', 'max:5000'],
            'medical_history' => ['nullable', 'string', 'max:5000'],
            'surgeries_history' => ['nullable', 'string', 'max:5000'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ], [
            'full_name.required' => 'أدخل اسم المريض.',
            'full_name.max' => 'الاسم طويل جدًا.',
            'patient_number.unique' => 'رقم المريض مستخدم مسبقًا في هذه العيادة.',
            'gender.in' => 'اختر الجنس بشكل صحيح.',
            'birth_date.date' => 'تاريخ الميلاد غير صحيح.',
            'birth_date.before_or_equal' => 'تاريخ الميلاد لا يمكن أن يكون في المستقبل.',
            'age.integer' => 'العمر يجب أن يكون رقمًا.',
            'age.min' => 'العمر غير صحيح.',
            'age.max' => 'العمر غير صحيح.',
        ]);
    }

    private function authorizeClinic(Request $request, Patient $patient): void
    {
        abort_unless(
            (int) $patient->clinic_id === (int) $request->user()->clinic_id,
            404
        );
    }
}
