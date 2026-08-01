@php
    /** @var \App\Models\Patient|null $patient */
    $patient = $patient ?? null;
    $suggestedNumber = $suggestedNumber ?? null;
@endphp

<div class="rounded-2xl border border-eye-aqua/20 bg-eye-sky/50 p-4">
    <label for="patient_number" class="field-label">رقم المريض (للسجلات السابقة)</label>
    <input
        id="patient_number"
        name="patient_number"
        type="text"
        value="{{ old('patient_number', $patient?->patient_number ?? $suggestedNumber) }}"
        class="field-input"
        placeholder="مثال: 120"
        dir="ltr"
        @if (! $patient) autofocus @endif
    >
    <p class="mt-2 text-base text-eye-ink-soft">يُستخدم للبحث عن الإضبارة القديمة بسهولة. إن تركته فارغًا يُعطى رقمًا تلقائيًا.</p>
</div>

<div>
    <label for="full_name" class="field-label">اسم المريض الكامل</label>
    <input
        id="full_name"
        name="full_name"
        type="text"
        value="{{ old('full_name', $patient?->full_name) }}"
        class="field-input"
        required
        @if ($patient) autofocus @endif
    >
</div>

<div>
    <label for="gender" class="field-label">الجنس (اختياري)</label>
    <select id="gender" name="gender" class="field-input">
        <option value="">—</option>
        <option value="male" @selected(old('gender', $patient?->gender) === 'male')>ذكر</option>
        <option value="female" @selected(old('gender', $patient?->gender) === 'female')>أنثى</option>
    </select>
</div>

<div>
    <label for="phone" class="field-label">رقم الهاتف (اختياري)</label>
    <input
        id="phone"
        name="phone"
        type="text"
        value="{{ old('phone', $patient?->phone) }}"
        class="field-input"
        dir="ltr"
    >
</div>

<div>
    <label for="address" class="field-label">العنوان (اختياري)</label>
    <input
        id="address"
        name="address"
        type="text"
        value="{{ old('address', $patient?->address) }}"
        class="field-input"
        placeholder="المدينة / الحي"
    >
</div>

<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <label for="age" class="field-label">العمر (اختياري)</label>
        <input
            id="age"
            name="age"
            type="number"
            min="0"
            max="120"
            value="{{ old('age', $patient?->age) }}"
            class="field-input"
            dir="ltr"
        >
    </div>
    <div>
        <label for="birth_date" class="field-label">تاريخ الميلاد (اختياري)</label>
        <input
            id="birth_date"
            name="birth_date"
            type="date"
            value="{{ old('birth_date', optional($patient?->birth_date)->format('Y-m-d')) }}"
            class="field-input"
            dir="ltr"
        >
    </div>
</div>

<div class="rounded-2xl border border-eye-aqua/20 bg-eye-sky/50 p-4">
    <label for="diagnosis" class="field-label">ماذا يعاني؟ (التشخيص العيني)</label>
    <textarea
        id="diagnosis"
        name="diagnosis"
        class="field-textarea"
        placeholder="مثال: ماء أبيض في العين اليمنى"
    >{{ old('diagnosis', $patient?->diagnosis) }}</textarea>
</div>

<div>
    <label for="previous_medications" class="field-label">الأدوية السابقة</label>
    <textarea
        id="previous_medications"
        name="previous_medications"
        class="field-textarea"
        placeholder="مثال: قطرة مضاد حيوي، أقراص ضغط..."
    >{{ old('previous_medications', $patient?->previous_medications) }}</textarea>
</div>

<div>
    <label for="current_medications" class="field-label">الأدوية الحالية</label>
    <textarea
        id="current_medications"
        name="current_medications"
        class="field-textarea"
        placeholder="ما يتناوله الآن"
    >{{ old('current_medications', $patient?->current_medications) }}</textarea>
</div>

<div>
    <label for="allergies" class="field-label">الحساسية من الأدوية أو غيرها</label>
    <textarea
        id="allergies"
        name="allergies"
        class="field-textarea"
        placeholder="مثال: حساسية من البنسلين"
    >{{ old('allergies', $patient?->allergies) }}</textarea>
</div>

<div>
    <label for="medical_history" class="field-label">التاريخ المرضي / الأمراض المزمنة</label>
    <textarea
        id="medical_history"
        name="medical_history"
        class="field-textarea"
        placeholder="مثال: سكري، ضغط، أمراض قلب..."
    >{{ old('medical_history', $patient?->medical_history) }}</textarea>
</div>

<div>
    <label for="surgeries_history" class="field-label">عمليات سابقة (خاصة بالعين إن وجدت)</label>
    <textarea
        id="surgeries_history"
        name="surgeries_history"
        class="field-textarea"
        placeholder="مثال: عملية ماء أبيض سنة 2022"
    >{{ old('surgeries_history', $patient?->surgeries_history) }}</textarea>
</div>

<div>
    <label for="notes" class="field-label">ملاحظات إضافية</label>
    <textarea
        id="notes"
        name="notes"
        class="field-textarea"
        placeholder="أي معلومة مهمة أخرى عن المريض"
    >{{ old('notes', $patient?->notes) }}</textarea>
</div>
