FROM php:latest
WORKDIR /var/www/html
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    vim \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
    wget \
    build-essential \
    cmake \
    libopencv-dev \
    && rm -rf /var/lib/apt/lists/*
COPY . .

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN sed -E -i -e 's/max_execution_time = 30/max_execution_time = 120/' "$PHP_INI_DIR/php.ini" \
 && sed -E -i -e 's/memory_limit = 128M/memory_limit = 512M/' "$PHP_INI_DIR/php.ini" \
 && sed -E -i -e 's/post_max_size = 8M/post_max_size = 64M/' "$PHP_INI_DIR/php.ini" \
 && sed -E -i -e 's/upload_max_filesize = 2M/upload_max_filesize = 64M/' "$PHP_INI_DIR/php.ini" \
 && sed -E -i -e 's/;max_input_vars = 1000/max_input_vars = 3000/' "$PHP_INI_DIR/php.ini"

RUN docker-php-ext-install pdo pdo_mysql
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Instala OpenCV
RUN wget https://raw.githubusercontent.com/php-opencv/php-opencv-packages/master/opencv_4.7.0_amd64.deb && \
    dpkg -i opencv_4.7.0_amd64.deb || apt-get install -f -y && \
    dpkg -i opencv_4.7.0_amd64.deb && \
    rm opencv_4.7.0_amd64.deb

# Compila extensão PHP do OpenCV
RUN git clone https://github.com/php-opencv/php-opencv.git && \
    cd php-opencv && \
    phpize && \
    ./configure --with-php-config=/usr/local/bin/php-config && \
    make && \
    make install && \
    echo "extension=opencv.so" > /usr/local/etc/php/conf.d/opencv.ini

CMD ["php", "-S","0.0.0.0:8000","-t","public"]