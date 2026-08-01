@extends('layouts.app')

@section('title', 'مريض جديد')

@section('content')
    <div class="mb-5">
        <a href="{{ route('home') }}" class="nav-back">
            <span aria-hidden="true">→</span>
            الرجوع للرئيسية
        </a>
    </div>

    <div class="stagger space-y-5">
        <section class="surface-soft">
            <p class="text-sm font-bold text-eye-aqua">إضبارة جديدة</p>
            <h2 class="mt-1 text-3xl font-bold text-eye-ink">مريض جديد</h2>
            <p class="mt-2 text-lg text-eye-ink-soft">املئي البيانات بوضوح، ثم احفظي الإضبارة.</p>
        </section>

        <section class="surface">
            <form method="POST" action="{{ route('patients.store') }}" class="space-y-5">
                @csrf
                @include('patients._form', ['suggestedNumber' => $suggestedNumber])
                <button type="submit" class="btn-primary">حفظ الإضبارة</button>
            </form>
        </section>
    </div>
@endsection
