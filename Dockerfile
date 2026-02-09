# 1. ใช้ PHP 8.4-fpm เป็น Base Image
# (ถ้า 8.4 ยังไม่มีในระบบให้ลอง 8.3 แต่จาก log คุณ Symfony บังคับ 8.4)
FROM php:8.4-fpm-bookworm

# 2. ติดตั้ง System Dependencies ที่จำเป็น
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# 3. ล้าง Cache เพื่อลดขนาด Image
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 4. ติดตั้ง PHP Extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 5. ติดตั้ง Composer จาก Image ทางการ
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. ตั้งค่า Directory ในการทำงาน
WORKDIR /var/www

# 7. คัดลอกไฟล์โปรเจกต์เข้าไป
COPY . .

# 8. รัน Composer Install
# (ใช้ --ignore-platform-reqs หากยังติดปัญหาเวอร์ชัน PHP ในขั้นตอน build)
RUN composer install --optimize-autoloader --no-scripts --no-interaction

# 9. เปิดพอร์ตและรัน PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]