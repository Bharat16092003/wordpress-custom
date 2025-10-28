FROM wordpress:latest
WORKDIR /var/www/html
COPY wp-content/ /var/www/html/wp-content/
EXPOSE 80

