const INSTALL_DISMISS_KEY = 'eye-clinic-pwa-dismissed';

function isStandalone() {
    return window.matchMedia('(display-mode: standalone)').matches
        || window.navigator.standalone === true;
}

function isIos() {
    return /iphone|ipad|ipod/i.test(window.navigator.userAgent);
}

function registerServiceWorker() {
    if (!('serviceWorker' in navigator)) {
        return;
    }

    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js').catch(() => {
            // Silent fail keeps the clinic UI usable even if SW registration fails.
        });
    });
}

function createInstallBanner({ title, body, actionLabel, onAction, onDismiss }) {
    if (document.getElementById('pwa-install-banner')) {
        return;
    }

    const banner = document.createElement('div');
    banner.id = 'pwa-install-banner';
    banner.className = 'pwa-install-banner';
    banner.innerHTML = `
        <div class="pwa-install-banner__text">
            <strong>${title}</strong>
            <p>${body}</p>
        </div>
        <div class="pwa-install-banner__actions">
            <button type="button" class="pwa-install-banner__btn" data-pwa-action>${actionLabel}</button>
            <button type="button" class="pwa-install-banner__dismiss" data-pwa-dismiss aria-label="إغلاق">×</button>
        </div>
    `;

    banner.querySelector('[data-pwa-action]').addEventListener('click', onAction);
    banner.querySelector('[data-pwa-dismiss]').addEventListener('click', () => {
        localStorage.setItem(INSTALL_DISMISS_KEY, '1');
        banner.remove();
        onDismiss?.();
    });

    document.body.appendChild(banner);
}

function setupInstallPrompt() {
    if (isStandalone() || localStorage.getItem(INSTALL_DISMISS_KEY) === '1') {
        return;
    }

    let deferredPrompt = null;

    window.addEventListener('beforeinstallprompt', (event) => {
        event.preventDefault();
        deferredPrompt = event;

        createInstallBanner({
            title: 'ثبّتي التطبيق على الجوال',
            body: 'يفتح مثل تطبيق عادي من الشاشة الرئيسية بدون شريط المتصفح.',
            actionLabel: 'تثبيت',
            onAction: async () => {
                if (!deferredPrompt) {
                    return;
                }

                deferredPrompt.prompt();
                await deferredPrompt.userChoice;
                deferredPrompt = null;
                document.getElementById('pwa-install-banner')?.remove();
            },
        });
    });

    if (isIos()) {
        createInstallBanner({
            title: 'أضيفي عيادة العيون لشاشتك',
            body: 'من زر المشاركة في سفاري اختاري «إضافة إلى الشاشة الرئيسية».',
            actionLabel: 'حسناً',
            onAction: () => {
                localStorage.setItem(INSTALL_DISMISS_KEY, '1');
                document.getElementById('pwa-install-banner')?.remove();
            },
        });
    }
}

registerServiceWorker();
setupInstallPrompt();
