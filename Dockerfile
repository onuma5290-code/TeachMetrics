# Stage 1: Build dependencies
FROM php:8.4-cli-bookworm AS builder

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
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ติดตั้ง PHP Extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# ติดตั้ง Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# คัดลอก composer files
COPY composer.json composer.lock ./

# รัน Composer install (ใช้ lock file เพื่อความสม่ำเสมอ)
RUN composer install --optimize-autoloader --no-dev --no-interaction --no-scripts

# Stage 2: Final image
FROM php:8.4-cli-bookworm

# ติดตั้ง runtime dependencies เท่านั้น
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ติดตั้ง PHP Extensions
RUN docker-php-ext-install pdo pdo_sqlite

WORKDIR /var/www

# คัดลอก vendor จาก builder stage
COPY --from=builder /var/www/vendor ./vendor

# คัดลอกไฟล์โปรเจกต์
COPY . .

# คัดลอก .env สำหรับ production
RUN cp .env.railway .env || echo "No .env.railway found"

# สร้าง SQLite database และ storage directories
RUN mkdir -p database storage/framework/{cache,sessions,views} storage/logs bootstrap/cache \
    && touch database/database.sqlite \
    && chmod -R 777 storage bootstrap/cache database

# ลบ cache เก่า
RUN php artisan config:clear || true

# เปิดพอร์ต
EXPOSE 8080

# รัน migrations และ start server
CMD php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8080}