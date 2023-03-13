FROM php:8.1.1-cli-alpine
RUN useradd -ms /bin/bash $USER
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"
RUN chmod -R $USER:$USER /var/www/html
USER $USER
