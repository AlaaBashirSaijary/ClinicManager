@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
    <div class="mx-auto max-w-md stagger">
        <div class="surface-soft mb-5 text-center">
            <p class="text-sm font-bold text-eye-aqua">مرحباً بك</p>
            <h2 class="mt-1 text-3xl font-bold text-eye-ink">تسجيل الدخول</h2>
            <p class="mt-2 text-lg leading-relaxed text-eye-ink-soft">
                ادخلي لفتح سجلات عيادتك فقط — بأمان ووضوح.
            </p>
        </div>

        <div class="surface">
            <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="field-label">البريد الإلكتروني</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        class="field-input"
                        autocomplete="username"
                        required
                        autofocus
                        dir="ltr"
                    >
                </div>

                <div>
                    <label for="password" class="field-label">كلمة المرور</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="field-input"
                        autocomplete="current-password"
                        required
                        dir="ltr"
                    >
                </div>

                <label class="flex items-center gap-3 text-lg text-eye-ink-soft">
                    <input type="checkbox" name="remember" value="1" class="size-5 rounded border-eye-ink/25 text-eye-aqua focus:ring-eye-aqua">
                    تذكّرني على هذا الجهاز
                </label>

                <button type="submit" class="btn-primary">دخول إلى العيادة</button>
            </form>
        </div>
    </div>
@endsection
