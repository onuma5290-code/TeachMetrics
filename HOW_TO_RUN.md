# วิธีรันโปรแกรม TeachMetrics

## 1. เตรียมความพร้อม

### ติดตั้ง Dependencies
```bash
cd F:\TeachMetrics\TeachMetrics
composer install
npm install
```

### ตั้งค่า Environment
```bash
# Copy .env.example ถ้ายังไม่มี .env
copy .env.example .env

# Generate Application Key
php artisan key:generate
```

### ตั้งค่าฐานข้อมูล
แก้ไขไฟล์ `.env` ให้ตรงกับการตั้งค่า MySQL ของคุณ:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=teacher_evaluation_db
DB_USERNAME=root
DB_PASSWORD=
```

### สร้างฐานข้อมูล
```bash
# สร้างฐานข้อมูลใน MySQL
# หรือ import ไฟล์ teacher_evaluation_db.sql

# หรือใช้ Migration (แนะนำ)
php artisan migrate:fresh --seed
```

## 2. รันโปรแกรม

### รัน Backend (Laravel)
```bash
cd F:\TeachMetrics\TeachMetrics
php artisan serve
```
เปิดที่: http://localhost:8000

### รัน Frontend (Vite) - Terminal แยก
```bash
cd F:\TeachMetrics\TeachMetrics
npm run dev
```

## 3. ทดสอบระบบ

### บัญชีทดสอบ (หลังรัน seed)
- **นักเรียน**: `studenttest` / `123456`
- **ครู**: `teachertest` / `123456`

## 4. รัน Tests

### รัน PHPUnit Tests
```bash
cd F:\TeachMetrics\TeachMetrics
php artisan test
```

### รัน Test เฉพาะไฟล์
```bash
php artisan test --filter=AuthenticationTest
php artisan test --filter=StudentModuleTest
php artisan test --filter=TeacherModuleTest
```

## 5. คำสั่งที่มีประโยชน์

```bash
# ล้างข้อมูลและสร้างใหม่
php artisan migrate:fresh --seed

# ล้าง Cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# ดูรายการ Routes
php artisan route:list
```

## หมายเหตุ
- ตรวจสอบว่า MySQL Server เปิดอยู่
- ตรวจสอบว่าสร้างฐานข้อมูล `teacher_evaluation_db` แล้ว
- Port 8000 ต้องไม่ถูกใช้งานโดยโปรแกรมอื่น
