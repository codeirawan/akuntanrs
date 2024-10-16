# Start with the official PHP image
FROM php:8.1-apache

# Install required dependencies
RUN apt-get update && apt-get install -y \
    libssl-dev \
    && docker-php-ext-install pdo pdo_mysql

# Copy your application files
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html/
