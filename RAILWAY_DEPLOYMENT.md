# 🚀 Deploy TeachMetrics บน Railway

## ✅ ไฟล์ที่เตรียมไว้แล้ว

โปรเจกต์นี้พร้อม deploy บน Railway แล้ว! ไฟล์ที่สำคัญ:

- ✅ **Procfile** - คำสั่งเริ่มต้นแอปพลิเคชัน
- ✅ **nixpacks.toml** - การตั้งค่า build process
- ✅ **.railwayignore** - ไฟล์ที่ไม่ต้อง deploy
- ✅ **.env.production.example** - ตัวอย่าง environment variables

## 📋 ขั้นตอนการ Deploy

### 1. สร้าง GitHub Repository

```bash
# ถ้ายังไม่มี GitHub repo ให้สร้างที่ github.com ก่อน
# จากนั้นรันคำสั่ง:

git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPO_NAME.git
git branch -M main
git push -u origin main
```

### 2. Deploy บน Railway

1. ไปที่ [Railway.app](https://railway.app)
2. คลิก **"New Project"**
3. เลือก **"Deploy from GitHub repo"**
4. เลือก repository ของคุณ
5. Railway จะ deploy อัตโนมัติ

### 3. ตั้งค่า Environment Variables

ใน Railway Dashboard → **Variables** เพิ่มตัวแปรเหล่านี้:

**⚠️ สำคัญที่สุด:**
```env
APP_KEY=
```
สร้าง APP_KEY ใหม่ด้วยคำสั่ง:
```bash
php artisan key:generate --show
```
คัดลอกค่าที่ได้ไปใส่ใน Railway

**ตัวแปรอื่นๆ:**
```env
APP_NAME=TeachMetrics
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.up.railway.app

LOG_LEVEL=error

DB_CONNECTION=sqlite

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

### 4. ตรวจสอบการ Deploy

1. ดู **Logs** ใน Railway Dashboard
2. เมื่อ deploy สำเร็จ จะได้ URL เช่น `https://your-app-name.up.railway.app`
3. เปิด URL เพื่อทดสอบแอปพลิเคชัน

## 🔄 การอัพเดตโค้ด

เมื่อต้องการอัพเดต:

```bash
git add .
git commit -m "Your update message"
git push
```

Railway จะ deploy ใหม่อัตโนมัติ

## 🗄️ ใช้ PostgreSQL แทน SQLite (ถ้าต้องการ)

### เพิ่ม PostgreSQL Database:

1. ใน Railway Project คลิก **"+ New"**
2. เลือก **"Database"** → **"PostgreSQL"**
3. Railway จะสร้าง environment variables อัตโนมัติ

### อัพเดต Environment Variables:

```env
DB_CONNECTION=pgsql
DB_HOST=${PGHOST}
DB_PORT=${PGPORT}
DB_DATABASE=${PGDATABASE}
DB_USERNAME=${PGUSER}
DB_PASSWORD=${PGPASSWORD}
```

## ❗ Troubleshooting

### Deploy ไม่สำเร็จ:
- ✅ ตรวจสอบ **Logs** ใน Railway Dashboard
- ✅ ตรวจสอบว่าตั้งค่า `APP_KEY` แล้ว
- ✅ ตรวจสอบว่า PHP version ตรงกับ composer.json (^8.2)

### Database Error:
- ✅ ตรวจสอบว่า migration รันสำเร็จใน Logs
- ✅ สำหรับ SQLite: ไฟล์ database.sqlite จะถูกสร้างอัตโนมัติ
- ✅ สำหรับ PostgreSQL: ตรวจสอบ DB credentials

### 500 Error:
- ✅ ตั้งค่า `APP_DEBUG=true` ชั่วคราวเพื่อดู error message
- ✅ ตรวจสอบ storage permissions
- ✅ ตรวจสอบว่า cache ถูก clear แล้ว

## � เอกสารเพิ่มเติม

- [Railway Documentation](https://docs.railway.app)
- [Laravel Deployment](https://laravel.com/docs/deployment)
- [Nixpacks](https://nixpacks.com)

## 🎯 สิ่งที่ Railway ทำอัตโนมัติ

1. ติดตั้ง PHP 8.4, Composer, Node.js, SQLite
2. รัน `composer install --no-dev --optimize-autoloader`
3. รัน `npm ci && npm run build`
4. สร้าง database และ storage directories
5. Cache config, routes, views
6. รัน migrations
7. เริ่ม Laravel server

---

**พร้อม Deploy แล้ว! 🚀**
