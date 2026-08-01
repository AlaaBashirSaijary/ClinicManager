# ClinicManager — عيادة العيون

نظام بسيط لإدارة سجلات مرضى عيادة عيون (حلب / جسر الشغور)، بواجهة عربية سهلة ودعم PWA للتثبيت على الجوال.

## المميزات

- بحث عن المريض بالاسم أو رقم الإضبارة أو الهاتف
- إضبارة كاملة: التشخيص، الأدوية، الحساسية، التاريخ المرضي، العمليات
- عزل تام بين عيادتي حلب وجسر الشغور
- واجهة عربية كبيرة وواضحة للمستخدمين قليلي الخبرة بالحاسوب
- Progressive Web App (يمكن تثبيته كتطبيق على الموبايل)

## تشغيل محلي

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

افتح: `http://127.0.0.1:8000`

## حسابات تجريبية

| العيادة | البريد | كلمة المرور |
|---------|--------|-------------|
| حلب | `nurse.aleppo@clinic.test` | `password` |
| جسر الشغور | `nurse.jisr@clinic.test` | `password` |

## النشر المجاني بدون بطاقة بنكية (Serv00)

الخيار المناسب: **[Serv00](https://www.serv00.com/)**  
مجاني، بدون إعلانات، و**بدون بطاقة بنكية**، مع PHP + MySQL + SSH.

الخطوات المختصرة:

1. سجّل حسابًا على https://www.serv00.com/ (التكلفة `$0`).
2. من لوحة التحكم أنشئ موقعًا (subdomain مجاني) وقاعدة MySQL.
3. ارفع المشروع عبر SFTP/SSH.
4. جهّز ملف `.env` ثم نفّذ:

```bash
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force --class=ClinicSeeder
```

الدليل الكامل خطوة بخطوة: [deploy/SERV00.md](deploy/SERV00.md)

> ملاحظة: منصات مثل Render غالبًا تطلب بطاقة حتى مع الخطة المجانية؛ لذلك لا نعتمدها هنا.

## PWA على الجوال

- Android Chrome: قائمة المتصفح → تثبيت التطبيق / إضافة للشاشة الرئيسية
- iPhone Safari: مشاركة → إضافة إلى الشاشة الرئيسية

يعمل التثبيت بشكل أفضل مع HTTPS (Serv00 يوفّر شهادة مجانية).
