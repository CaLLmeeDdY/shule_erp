# Use the official PHP 8.2 CLI image
FROM php:8.2-cli

# Install system dependencies and PHP extensions required by Laravel
RUN apt-get update -y && apt-get install -y \
    libonig-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql mbstring zip

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory inside the container
WORKDIR /app

# Copy your application code into the container
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Start the Laravel server and bind it to Render's dynamic PORT
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}