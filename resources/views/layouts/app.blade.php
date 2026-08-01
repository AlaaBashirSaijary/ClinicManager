<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1287a0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="عيادة العيون">
    <meta name="application-name" content="عيادة العيون">
    <meta name="description" content="إدارة سجلات مرضى عيادة العيون بسهولة على الجوال والكمبيوتر">
    <title>@yield('title', 'إدارة العيادة') — عيادة العيون</title>
    <link rel="manifest" href="/manifest.webmanifest">
    <link rel="icon" type="image/png" sizes="192x192" href="/icons/icon-192.png">
    <link rel="apple-touch-icon" href="/icons/apple-touch-icon.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=ibm-plex-sans-arabic:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-shell">
        <header class="mb-7 flex items-start justify-between gap-4 page-enter">
            <div class="flex items-center gap-3">
                <div class="brand-mark" aria-hidden="true"></div>
                <div>
                    <p class="text-sm font-bold tracking-wide text-eye-aqua">عيادة العيون</p>
                    @auth
                        <h1 class="text-2xl font-bold leading-tight text-eye-ink">{{ auth()->user()->clinic?->name }}</h1>
                        <p class="text-base text-eye-ink-soft">{{ auth()->user()->name }}</p>
                    @else
                        <h1 class="text-2xl font-bold leading-tight text-eye-ink">سجلات المرضى</h1>
                        <p class="text-base text-eye-ink-soft">وضوح… رعاية… متابعة</p>
                    @endauth
                </div>
            </div>

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-xl border border-eye-ink/10 bg-white/80 px-4 py-3 text-base font-bold text-eye-ink-soft transition hover:bg-white hover:text-eye-ink">
                        خروج
                    </button>
                </form>
            @endauth
        </header>

        @if (session('success'))
            <div class="alert-ok" role="status">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-error" role="alert">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <main class="flex-1 page-enter">
            @yield('content')
        </main>

        <footer class="mt-10 pb-2 text-center text-sm text-eye-ink-soft/70">
            عيادة العيون — رعاية دقيقة لنظر أوضح
        </footer>
    </div>
</body>
</html>
