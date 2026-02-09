# ใช้ PHP 8.4 CLI สำหรับ Laravel
FROM php:8.4-cli-bookworm

# ติดตั้ง System Dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ติดตั้ง PHP Extensions
RUN docker-php-ext-install pdo pdo_sqlite pdo_mysql mbstring exif pcntl bcmath gd zip

# ติดตั้ง Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ตั้งค่า Working Directory
WORKDIR /var/www

# คัดลอกไฟล์โปรเจกต์
COPY . .

# คัดลอก .env สำหรับ production
RUN cp .env.railway .env || echo "No .env.railway found, using environment variables"

# รัน Composer Install
RUN composer install --optimize-autoloader --no-dev --no-interaction

# สร้าง SQLite database และ storage directories
RUN mkdir -p database storage/framework/cache storage/framework/sessions storage/framework/views storage/logs \
    && touch database/database.sqlite \
    && chmod -R 777 storage bootstrap/cache database \
    && chown -R www-data:www-data storage bootstrap/cache database || true

# ลบ cache เก่า
RUN php artisan config:clear || true \
    && php artisan cache:clear || true \
    && php artisan view:clear || true

# เปิดพอร์ต
EXPOSE 8080

# รัน migrations และ start server
CMD php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8080}