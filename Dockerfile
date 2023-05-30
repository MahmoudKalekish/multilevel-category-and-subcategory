# Use the official PHP image as the base image
FROM php:8.1-cli

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy the application files to the container
COPY . .

# Install dependencies and necessary extensions
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Expose the port where your PHP application will run (if applicable)
EXPOSE 8000

# Start the PHP development server
CMD ["php", "-S", "0.0.0.0:8000", "-t", "."]
