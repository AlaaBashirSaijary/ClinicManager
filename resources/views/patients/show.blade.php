@extends('layouts.app')

@section('title', 'إضبارة '.$patient->full_name)

@section('content')
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('patients.index') }}" class="nav-back">
            <span aria-hidden="true">→</span>
            رجوع للبحث
        </a>
        <a href="{{ route('home') }}" class="text-lg font-bold text-eye-ink-soft transition hover:text-eye-ink">الرئيسية</a>
    </div>

    <div class="stagger space-y-5">
        <section class="surface">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-sm font-bold text-eye-aqua">{{ $patient->clinic->name }}</p>
                    <h2 class="mt-1 text-4xl font-bold leading-tight text-eye-ink">{{ $patient->full_name }}</h2>
                </div>
                <div class="rounded-2xl bg-eye-sky px-4 py-3 text-center">
                    <p class="text-sm font-bold text-eye-ink-soft">رقم المريض</p>
                    <p class="text-2xl font-bold text-eye-aqua" dir="ltr">{{ $patient->patient_number ?: '—' }}</p>
                </div>
            </div>
        </section>

        <section class="diagnosis-hero">
            <p class="relative z-10 text-sm font-bold text-eye-aqua">التشخيص العيني</p>
            <p class="relative z-10 mt-1 text-lg font-bold text-eye-ink-soft">ماذا يعاني؟</p>
            <p class="relative z-10 mt-3 text-2xl font-bold leading-relaxed text-eye-ink">
                {{ $patient->diagnosis ?: 'غير محدد بعد' }}
            </p>
        </section>

        <section class="surface space-y-1">
            <h3 class="mb-2 text-xl font-bold text-eye-ink">بيانات المريض</h3>
            <div class="meta-row">
                <span class="font-bold text-eye-ink-soft">الجنس</span>
                <span class="font-bold text-eye-ink">{{ $patient->genderLabel() }}</span>
            </div>
            <div class="meta-row">
                <span class="font-bold text-eye-ink-soft">الهاتف</span>
                <span class="font-bold text-eye-ink" dir="ltr">{{ $patient->phone ?: '—' }}</span>
            </div>
            <div class="meta-row">
                <span class="font-bold text-eye-ink-soft">العنوان</span>
                <span class="font-bold text-eye-ink">{{ $patient->address ?: '—' }}</span>
            </div>
            <div class="meta-row">
                <span class="font-bold text-eye-ink-soft">العمر</span>
                <span class="font-bold text-eye-ink">{{ $patient->displayAge() !== null ? $patient->displayAge().' سنة' : '—' }}</span>
            </div>
            <div class="meta-row">
                <span class="font-bold text-eye-ink-soft">تاريخ الميلاد</span>
                <span class="font-bold text-eye-ink" dir="ltr">{{ $patient->birth_date?->format('Y-m-d') ?: '—' }}</span>
            </div>
        </section>

        <section class="surface space-y-4">
            <h3 class="text-xl font-bold text-eye-ink">التاريخ الطبي والأدوية</h3>

            <div>
                <p class="mb-1 font-bold text-eye-aqua">الأدوية السابقة</p>
                <p class="text-xl leading-relaxed text-eye-ink">{{ $patient->previous_medications ?: '—' }}</p>
            </div>
            <div>
                <p class="mb-1 font-bold text-eye-aqua">الأدوية الحالية</p>
                <p class="text-xl leading-relaxed text-eye-ink">{{ $patient->current_medications ?: '—' }}</p>
            </div>
            <div>
                <p class="mb-1 font-bold text-eye-focus">الحساسية</p>
                <p class="text-xl leading-relaxed text-eye-ink">{{ $patient->allergies ?: '—' }}</p>
            </div>
            <div>
                <p class="mb-1 font-bold text-eye-ink-soft">التاريخ المرضي / الأمراض المزمنة</p>
                <p class="text-xl leading-relaxed text-eye-ink">{{ $patient->medical_history ?: '—' }}</p>
            </div>
            <div>
                <p class="mb-1 font-bold text-eye-ink-soft">عمليات سابقة</p>
                <p class="text-xl leading-relaxed text-eye-ink">{{ $patient->surgeries_history ?: '—' }}</p>
            </div>
            <div>
                <p class="mb-1 font-bold text-eye-ink-soft">ملاحظات إضافية</p>
                <p class="text-xl leading-relaxed text-eye-ink">{{ $patient->notes ?: '—' }}</p>
            </div>
        </section>

        <div class="space-y-3">
            <a href="{{ route('patients.edit', $patient) }}" class="btn-primary">تعديل الإضبارة</a>
            <a href="{{ route('patients.index') }}" class="btn-secondary">بحث عن مريض آخر</a>
        </div>
    </div>
@endsection
