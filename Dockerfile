# Usar una imagen oficial de PHP con FPM
FROM php:8.2-fpm

# Instalar las dependencias necesarias, incluyendo ODBC
RUN apt-get update && apt-get install -y \
    unixodbc \
    unixodbc-dev \
    odbcinst \
    msodbcsql17 \
    libgssapi-krb5-2 \
    libodbc1 \
    && docker-php-ext-install pdo pdo_mysql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar el proyecto Laravel dentro del contenedor
WORKDIR /var/www
COPY . /var/www

# Configurar DSN ODBC
RUN echo "[ODBC Driver 17 for SQL Server]\nDriver=ODBC Driver 17 for SQL Server\nServer=your_sql_server_host,1433\nDatabase=raviera" > /etc/odbc.ini

EXPOSE 9000
CMD ["php-fpm"]
