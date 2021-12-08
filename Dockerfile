FROM logstash:7.14.2
USER root

WORKDIR /app
COPY . /app

#Establecimiento de la configuración de logstash
RUN rm /usr/share/logstash/pipeline/logstash.conf
COPY logstash.conf /usr/share/logstash/pipeline/

#Instalacion de  php7.4
RUN yum -y install https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
RUN yum -y install https://rpms.remirepo.net/enterprise/remi-release-7.rpm
RUN yum -y install yum-utils
RUN yum-config-manager --enable remi-php74
RUN yum update -y
RUN yum install -y php php-cli
#Librerias de php7.4
RUN yum install -y php-common php-pdo php-mysql php-xml
#Instalación composers
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#Librerias adicionales
RUN yum install -y git

#Descarga de dependencias del proyecto
RUN composer update
RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=8000

EXPOSE 8000