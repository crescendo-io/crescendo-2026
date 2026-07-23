# Docker

****

## Docker-compose

### Section services

chaque entrée est un container docker, pour le starterkit nous avons db / wp / nginx / node / composer / postgres / sonarqube

pour chaque entrée, on déclare :

- l'utilisation d'une image du hub https://hub.docker.com/search?q=
```
    image: mysql:5.7
```
ou si installation personnalisée, il est possible d'inclure une image puis d'installer ce qu'il nous faut (voir Dockerfile)
```
    build:
      context: .
      dockerfile: wordpress/Dockerfile
```
- le nom du container dans la stack
```
    container_name: ${APP_NAME}-db
```
- le mapping des ports : [port hote]:[port container]
```
    ports:
      - 3306:3306
```
- les dépendances vers d'autres containers : wordpress et db sont les noms des entrées de la section services
```
    depends_on:
      - wordpress
      - db
```
- le lien vers le volume : créera le volume creditagricole_chapeau-db_data lié au container creditagricole_chapeau-db par exemple (voir plus bas)
```
    volumes:
      - db_data:/var/lib/mysql
```
ou linkage des fichiers de l'hote vers le container (avec du cache ici)
```
    volumes:
      - ../.docker/wordpress/php.ini:/usr/local/etc/php/conf.d/php.ini
      - ../web:/var/www/html
      - ../web/wp-config-sample.php:/var/www/html/wp-config-sample.php
      - ../web/wp-content/uploads:/var/www/html/wp-content/uploads:cached
      - ../web/wp-content/plugins:/var/www/html/wp-content/plugins:cached
      - ../web/wp-includes:/var/www/html/wp-includes:cached
      - ../web/wp-admin:/var/www/html/wp-admin:cached
```
- les variables d'environnements 
```
    environment:
      MYSQL_DATABASE: ${DB_NAME}
      MYSQL_USER: ${DB_USER}
      MYSQL_ROOT_PASSWORD: ${DB_ROOT_PASSWORD}
      MYSQL_PASSWORD: ${DB_PASSWORD}
```
- falcultatif : l'utilisation d'une commande qui override l'entrypoint du container, ne pas oublier de lancer la commande nécessaire du container si celui-ci en possède une (php-fpm dans le cas présent)
```
    command: > 
      bash -c '
        if [ ! -d "/var/www/html/wp-content/themes/${WP_THEME_NAME}" ]
        then
            echo "Directory /path/to/dir DOES NOT exists." 
            mv /var/www/html/wp-content/themes/default /var/www/html/wp-content/themes/${WP_THEME_NAME}
        fi
        php-fpm
      '
```

### Section volumes

on déclare un volume db_data qui sera utilisé dans la section services
```
volumes:
  db_data: {}
```

## Dockerfile

il permet de personnaliser son container à partir d'une image du docker hub

pour référer à l'image on utilise : 
```
FROM wordpress:6.0.2-php8.0-fpm
```
ou encore 
```
FROM --platform=linux/amd64 node:14
```
on notera ici l'utilisation du flag **--platform=linux/amd64**, pour **<u>les puces M1 M2 d'apple ce flag sera nécessaire pour l'emploi des libraires d'images</u>**

pour le reste, on utilise quelques lignes d'installation avec
```
RUN
```

la cheat sheet qui va bien : https://kapeli.com/cheat_sheets/Dockerfile.docset/Contents/Resources/Documents/index






