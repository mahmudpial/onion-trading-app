FROM php:8.4-apache

# Install PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev nodejs npm \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies and build Vite assets
RUN npm install && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Configure Apache
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Startup script
RUN printf '#!/bin/bash\nphp artisan migrate --force\nphp artisan config:cache\nphp artisan route:cache\nphp artisan view:cache\napache2-foreground' > /start.sh
RUN chmod +x /start.sh

CMD ["/bin/bash", "/start.sh"]