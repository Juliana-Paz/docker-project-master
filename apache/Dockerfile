# Usando a imagem base do Ubuntu
FROM ubuntu:latest

# Atualizando o sistema e instalando o Apache e outros pacotes necessários
RUN apt-get update && apt-get install -y apache2 libapache2-mod-proxy-html libxml2-dev

# Copiando o arquivo de configuração personalizado para o Apache
COPY apache_php.conf /etc/apache2/sites-available/000-default.conf

# Habilitando os módulos necessários no Apache
RUN a2enmod proxy proxy_http proxy_fcgi rewrite deflate

# Configurando o servidor Apache para enviar logs para a saída padrão
RUN ln -sf /dev/stdout /var/log/apache2/access.log \
    && ln -sf /dev/stderr /var/log/apache2/error.log

# Expondo a porta 80 para acesso externo
EXPOSE 80

# Iniciando o servidor Apache em primeiro plano
CMD ["apachectl", "-D", "FOREGROUND"]
