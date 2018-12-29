#+++++++++++++++++++++++++++++++++++++++
# Dockerfile for webdevops/php-apache-dev:7.2
#    -- automatically generated  --
#+++++++++++++++++++++++++++++++++++++++

FROM webdevops/php-apache-dev:7.2

ENV WEB_DOCUMENT_ROOT=/var/www/public \
    WEB_DOCUMENT_INDEX=index.php \
    WEB_ALIAS_DOMAIN=*.vm \
    WEB_PHP_TIMEOUT=600 \
    WEB_PHP_SOCKET=""
ENV WEB_PHP_SOCKET=127.0.0.1:9000
ENV WEB_NO_CACHE_PATTERN="\.(css|js|gif|png|jpg|svg|json|xml)$" 
ENV BLACKFIRE_CLIENT_ID="b143138d-aee3-4971-800e-a36b5ba607f8"
ENV BLACKFIRE_CLIENT_TOKEN="ca8af640bd2e3cf026e432d15bd70157dfe802886eaf58a920fb867041ac53dd"
ENV BLACKFIRE_SERVER_ID="406086b1-e18f-4fc3-add1-85235bfc642d"
ENV BLACKFIRE_SERVER_TOKEN="3a4135fef37203512e4b9999662858bc70f47b7891d0eb282031b71da9b6c991"
 
