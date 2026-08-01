@extends('layouts.app')

@section('title', 'بحث عن مريض')

@section('content')
    <div class="mb-5">
        <a href="{{ route('home') }}" class="nav-back">
            <span aria-hidden="true">→</span>
            الرجوع للرئيسية
        </a>
    </div>

    <div class="stagger space-y-5">
        <section class="surface">
            <p class="text-sm font-bold text-eye-aqua">سجلات العيادة</p>
            <h2 class="mt-1 text-3xl font-bold text-eye-ink">بحث عن مريض</h2>
            <p class="mt-2 mb-6 text-lg text-eye-ink-soft">ابحثي بالاسم أو رقم المريض أو الهاتف.</p>

            <form method="GET" action="{{ route('patients.index') }}" id="patient-search-form" class="space-y-4">
                <div>
                    <label for="q" class="field-label">الاسم أو رقم المريض</label>
                    <input
                        id="q"
                        name="q"
                        type="search"
                        value="{{ $q }}"
                        class="field-input"
                        placeholder="مثال: أحمد أو 120"
                        autocomplete="off"
                        autofocus
                    >
                </div>
                <button type="submit" class="btn-primary">بحث في السجلات</button>
            </form>
        </section>

        @if ($searched)
            <section class="space-y-3">
                @forelse ($patients as $patient)
                    <a href="{{ route('patients.show', $patient) }}" class="result-row">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <div class="text-2xl font-bold text-eye-ink">{{ $patient->full_name }}</div>
                                    @if ($patient->patient_number)
                                        <span class="rounded-xl bg-eye-sky px-3 py-1 text-base font-bold text-eye-aqua" dir="ltr">
                                            #{{ $patient->patient_number }}
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-2 text-lg leading-relaxed text-eye-ink-soft">
                                    <span class="font-bold text-eye-aqua">ماذا يعاني:</span>
                                    {{ $patient->diagnosis ?: 'غير محدد' }}
                                </div>
                                @if ($patient->phone)
                                    <div class="mt-1 text-base text-eye-ink-soft/80" dir="ltr">{{ $patient->phone }}</div>
                                @endif
                            </div>
                            <span class="mt-1 text-eye-aqua text-xl" aria-hidden="true">‹</span>
                        </div>
                    </a>
                @empty
                    <div class="surface text-center">
                        <p class="text-xl font-bold text-eye-ink">لم يتم العثور على مريض.</p>
                        <p class="mt-2 text-lg text-eye-ink-soft">جرّبي الاسم أو الرقم، أو أضيفي إضبارة جديدة.</p>
                        <a href="{{ route('patients.create') }}" class="btn-accent mt-5">إضافة مريض جديد</a>
                    </div>
                @endforelse
            </section>
        @endif
    </div>

    <script>
        (() => {
            const input = document.getElementById('q');
            const form = document.getElementById('patient-search-form');
            if (!input || !form) return;

            let timer;
            input.addEventListener('input', () => {
                clearTimeout(timer);
                if (input.value.trim().length < 1) return;
                timer = setTimeout(() => form.requestSubmit(), 450);
            });
        })();
    </script>
@endsection
