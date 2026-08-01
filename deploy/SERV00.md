# نشر ClinicManager على Serv00 (مجاني بدون بطاقة)

Serv00 استضافة مجانية تدعم PHP وMySQL وSSH، **بدون بطاقة بنكية**.

## 1) إنشاء حساب

1. ادخل: https://www.serv00.com/
2. **Register** وأنشئ حسابًا (التكلفة `$0`).
3. انتظر رسالة التفعيل على الإيميل (فيها السيرفر مثل `s3.serv00.com` واسم المستخدم).

## 2) إنشاء موقع وقاعدة بيانات

من لوحة DevilWEB (مثل `https://panel3.serv00.com` حسب رقم سيرفرك):

1. **WWW** → أضف موقعًا (subdomain مجاني مثل `clinicmanager.USERNAME.serv00.net`).
2. اجعل مجلد الموقع يشير إلى مجلد المشروع، ويفضّل أن يكون الـ Document Root على مجلد `public`.
3. **MySQL** → أنشئ قاعدة بيانات + مستخدم + كلمة مرور، واحفظ البيانات.

## 3) رفع المشروع

من جهازك (بعد استنساخ المستودع):

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

ارفع الملفات عبر **SFTP/SSH** إلى مجلد الموقع (مثال):

`/home/USER/domains/YOUR_DOMAIN/public_html`

يمكنك:

```bash
rsync -avz --exclude .git --exclude node_modules --exclude .env \
  ./ USER@sX.serv00.com:~/domains/YOUR_DOMAIN/public_html/
```

أو ارفع بـ FileZilla (SFTP).

## 4) إعداد `.env` على السيرفر

أنشئ ملف `.env` في جذر المشروع على Serv00:

```env
APP_NAME="عيادة العيون"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://YOUR_DOMAIN

APP_LOCALE=ar
APP_FALLBACK_LOCALE=ar

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=YOUR_DB_NAME
DB_USERNAME=YOUR_DB_USER
DB_PASSWORD=YOUR_DB_PASSWORD

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr
```

ثم عبر SSH:

```bash
cd ~/domains/YOUR_DOMAIN/public_html
php83 artisan key:generate
php83 artisan migrate --force
php83 artisan db:seed --force --class=ClinicSeeder
php83 artisan config:clear
php83 artisan storage:link || true
```

> إن كان أمر PHP عندك `php` أو `php8.3` استخدم المتاح على السيرفر.

## 5) صلاحيات المجلدات

```bash
chmod -R ug+rwx storage bootstrap/cache
```

## 6) إن تعذّر تغيير Document Root إلى `public`

انسخ ملف التوجيه إلى جذر المشروع:

```bash
cp deploy/htaccess-root .htaccess
```

## حسابات التجربة بعد النشر

- حلب: `nurse.aleppo@clinic.test` / `password`
- جسر الشغور: `nurse.jisr@clinic.test` / `password`
