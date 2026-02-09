# 🚀 Deploy TeachMetrics บน Render

## ✅ โปรเจกต์พร้อม Deploy แล้ว!

ไฟล์ที่เตรียมไว้:
- ✅ **Dockerfile** - สำหรับ build Docker image
- ✅ **render.yaml** - Configuration สำหรับ Render
- ✅ **.env.railway** - Environment variables
- ✅ **GitHub Repository** - https://github.com/onuma5290-code/TeachMetrics

---

## 📋 ขั้นตอนการ Deploy

### ขั้นตอนที่ 1: เปิด Render Dashboard

1. ไปที่: **https://render.com**
2. คลิก **"Get Started"** หรือ **"Sign Up"**
3. เลือก **"Sign up with GitHub"**
4. Authorize Render เพื่อเข้าถึง GitHub repositories

### ขั้นตอนที่ 2: สร้าง Web Service

1. คลิกปุ่ม **"New +"** (มุมขวาบน)
2. เลือก **"Web Service"**
3. เลือก **"Build and deploy from a Git repository"**
4. คลิก **"Next"**

### ขั้นตอนที่ 3: เชื่อมต่อ GitHub Repository

1. ค้นหา repository: **onuma5290-code/TeachMetrics**
2. คลิก **"Connect"** ข้างๆ repository

### ขั้นตอนที่ 4: ตั้งค่า Service

กรอกข้อมูลดังนี้:

**Basic Settings:**
- **Name:** `teachmetrics` (หรือชื่อที่ต้องการ)
- **Region:** `Singapore` (ใกล้ไทยที่สุด)
- **Branch:** `main`
- **Root Directory:** (เว้นว่างไว้)

**Build Settings:**
- **Environment:** เลือก **Docker**
- **Dockerfile Path:** `Dockerfile`

**Instance Type:**
- เลือก **Free** (ฟรี)

### ขั้นตอนที่ 5: ตั้งค่า Environment Variables

เลื่อนลงมาหา **"Environment Variables"** section:

**วิธีที่ 1: เพิ่มทีละตัว**

คลิก **"Add Environment Variable"** และเพิ่มตัวแปรเหล่านี้:

| Key | Value |
|-----|-------|
| `APP_KEY` | `base64:P6MgqjWHjCWsSiGuCR8YKBggOHJLUwGZ857sXZ3zGE6U=` |
| `APP_NAME` | `TeachMetrics` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `DB_CONNECTION` | `sqlite` |
| `LOG_LEVEL` | `error` |
| `SESSION_DRIVER` | `file` |
| `CACHE_STORE` | `file` |
| `QUEUE_CONNECTION` | `sync` |
| `PORT` | `8080` |

**วิธีที่ 2: ใช้ Secret File (ง่ายกว่า)**

1. คลิก **"Add Secret File"**
2. **Filename:** `.env`
3. **Contents:** วางโค้ดนี้:

```env
APP_KEY=base64:P6MgqjWHjCWsSiGuCR8YKBggOHJLUwGZ857sXZ3zGE6U=
APP_NAME=TeachMetrics
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=sqlite
LOG_LEVEL=error
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
PORT=8080
```

### ขั้นตอนที่ 6: Deploy!

1. เลื่อนลงมาด้านล่างสุด
2. คลิกปุ่ม **"Create Web Service"** สีน้ำเงิน
3. Render จะเริ่ม build และ deploy อัตโนมัติ

### ขั้นตอนที่ 7: รอให้ Deploy เสร็จ

1. ดู **Build Logs** ที่แสดงอยู่
2. รอประมาณ **3-5 นาที** สำหรับ build ครั้งแรก
3. เมื่อเห็นข้อความ **"Your service is live 🎉"** แสดงว่าสำเร็จ!

### ขั้นตอนที่ 8: เปิดเว็บไซต์

1. คลิกที่ URL ด้านบน (เช่น `https://teachmetrics.onrender.com`)
2. หรือคลิกปุ่ม **"Open"** ที่มุมขวาบน
3. เว็บไซต์ของคุณพร้อมใช้งานแล้ว! 🎉

---

## 🔄 การอัพเดตโค้ด

เมื่อต้องการอัพเดตโค้ด:

1. แก้ไขโค้ดในเครื่อง
2. Commit และ Push ขึ้น GitHub:
   ```bash
   git add .
   git commit -m "Your update message"
   git push origin main
   ```
3. Render จะ detect การเปลี่ยนแปลงและ deploy ใหม่อัตโนมัติ

---

## ⚙️ ตั้งค่า Auto Deploy

Render จะ auto-deploy ทุกครั้งที่ push ขึ้น GitHub โดยอัตโนมัติ

ถ้าต้องการปิด auto-deploy:
1. ไปที่ **Settings** tab
2. เลื่อนลงหา **"Build & Deploy"**
3. ปิด **"Auto-Deploy"**

---

## 🗄️ เพิ่ม PostgreSQL Database (ถ้าต้องการ)

ถ้าต้องการใช้ PostgreSQL แทน SQLite:

1. ใน Render Dashboard คลิก **"New +"**
2. เลือก **"PostgreSQL"**
3. ตั้งชื่อ database
4. เลือก **Free** plan
5. คลิก **"Create Database"**
6. คัดลอก **Internal Database URL**
7. ไปที่ Web Service → **Environment** tab
8. เพิ่ม/แก้ไข variables:
   ```
   DB_CONNECTION=pgsql
   DATABASE_URL=<paste internal database URL>
   ```
9. Redeploy service

---

## ❗ Troubleshooting

### Build Failed

**สาเหตุ:** Dockerfile หรือ dependencies มีปัญหา

**วิธีแก้:**
1. ดู Build Logs
2. ตรวจสอบ error message
3. แก้ไขและ push ขึ้น GitHub ใหม่

### 500 Internal Server Error

**สาเหตุ:** Environment variables ไม่ครบหรือไม่ถูกต้อง

**วิธีแก้:**
1. ไปที่ **Environment** tab
2. ตรวจสอบว่ามี `APP_KEY` และตัวแปรอื่นๆ ครบ
3. ตั้งค่า `APP_DEBUG=true` ชั่วคราวเพื่อดู error
4. Redeploy

### Application Not Responding

**สาเหตุ:** Port ไม่ถูกต้อง

**วิธีแก้:**
1. ตรวจสอบว่ามี environment variable `PORT=8080`
2. ตรวจสอบว่า Dockerfile ใช้ `${PORT}` variable
3. Redeploy

### Free Instance Spins Down

**หมายเหตุ:** Free tier ของ Render จะ "sleep" หลังจากไม่มีการใช้งาน 15 นาที

- ครั้งแรกที่เปิดหลัง sleep จะใช้เวลา 30-60 วินาที
- ถ้าต้องการให้ online ตลอด ต้องอัพเกรดเป็น Paid plan ($7/เดือน)

---

## 📊 ข้อดีของ Render

✅ **ฟรี** - Free tier ใจกว้าง  
✅ **ง่าย** - ตั้งค่าง่ายกว่า Railway  
✅ **Auto Deploy** - Deploy อัตโนมัติเมื่อ push ขึ้น GitHub  
✅ **SSL ฟรี** - HTTPS อัตโนมัติ  
✅ **Database ฟรี** - PostgreSQL free tier  
✅ **Logs ดีกว่า** - ดู logs ง่ายกว่า Railway  

---

## 🔗 ลิงก์ที่เป็นประโยชน์

- [Render Documentation](https://render.com/docs)
- [Laravel on Render Guide](https://render.com/docs/deploy-laravel)
- [Render Community](https://community.render.com)

---

## 🎯 สรุป

1. ✅ ไปที่ https://render.com
2. ✅ Sign up ด้วย GitHub
3. ✅ New → Web Service
4. ✅ เลือก repository: onuma5290-code/TeachMetrics
5. ✅ เลือก Environment: Docker
6. ✅ เพิ่ม Environment Variables
7. ✅ Create Web Service
8. ✅ รอ 3-5 นาที
9. ✅ เปิดเว็บไซต์!

**พร้อม Deploy แล้ว! 🚀**
