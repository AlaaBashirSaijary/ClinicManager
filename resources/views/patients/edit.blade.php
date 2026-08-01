@extends('layouts.app')

@section('title', 'تعديل إضبارة')

@section('content')
    <div class="mb-5">
        <a href="{{ route('patients.show', $patient) }}" class="nav-back">
            <span aria-hidden="true">→</span>
            الرجوع للإضبارة
        </a>
    </div>

    <div class="stagger space-y-5">
        <section class="surface-soft">
            <p class="text-sm font-bold text-eye-aqua">تحديث السجل</p>
            <h2 class="mt-1 text-3xl font-bold text-eye-ink">تعديل إضبارة</h2>
            <p class="mt-2 text-lg text-eye-ink-soft">{{ $patient->full_name }}</p>
        </section>

        <section class="surface">
            <form method="POST" action="{{ route('patients.update', $patient) }}" class="space-y-5">
                @csrf
                @method('PUT')
                @include('patients._form', ['patient' => $patient])
                <button type="submit" class="btn-primary">حفظ التعديلات</button>
            </form>
        </section>
    </div>
@endsection
