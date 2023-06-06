# Use uma imagem base com Apache e PHP-FPM
FROM php:7.2.7-apache

# Atualiza os pacotes e suas dependências
RUN apt-get update && apt-get upgrade -y

# Instala o módulo mysqli no PHP
RUN docker-php-ext-install mysqli

# Instala o módulo mod_proxy do Apache
RUN a2enmod proxy proxy_fcgi

# Instala o módulo mod_proxy_html do Apache
RUN apt-get install -y libapache2-mod-proxy-html

# Copia o arquivo de configuração personalizado para o diretório correto
COPY apache_php.conf /etc/apache2/sites-available/000-default.conf

# Define as permissões corretas para o diretório de trabalho
RUN chown -R www-data:www-data /var/www/html

# Expõe a porta 80 do Apache para acesso externo
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]
