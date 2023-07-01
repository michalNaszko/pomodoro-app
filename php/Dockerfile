FROM php:8.0-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo pdo_mysql
RUN apt-get update && apt-get upgrade -y
RUN apt-get update && apt-get install -y python3.9 python3.9-dev python3-pip
RUN pip install pandas mysql-connector-python