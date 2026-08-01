@extends('layouts.app')

@section('title', 'الرئيسية')

@section('content')
    <div class="stagger space-y-5">
        <section class="surface-soft text-center">
            <p class="text-sm font-bold text-eye-aqua">لوحة الممرضة</p>
            <h2 class="mt-1 text-3xl font-bold text-eye-ink">ماذا تريدين أن تفعلي؟</h2>
            <p class="mt-2 text-lg text-eye-ink-soft">اختاري مهمة واحدة — ببساطة وسرعة.</p>
        </section>

        <a href="{{ route('patients.index') }}" class="action-tile-search block">
            <span class="relative z-10 block text-sm font-bold text-white/80">الوصول السريع</span>
            <span class="relative z-10 mt-2 block text-3xl font-bold">بحث عن مريض</span>
            <span class="relative z-10 mt-2 block text-lg text-white/85">ابحثي بالاسم وافتحي الإضبارة فورًا</span>
        </a>

        <a href="{{ route('patients.create') }}" class="action-tile-new block">
            <span class="relative z-10 block text-sm font-bold text-white/80">تسجيل جديد</span>
            <span class="relative z-10 mt-2 block text-3xl font-bold">مريض جديد</span>
            <span class="relative z-10 mt-2 block text-lg text-white/85">أنشئي إضبارة واضحة مع التشخيص</span>
        </a>
    </div>
@endsection
