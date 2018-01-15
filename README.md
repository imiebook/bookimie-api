# Docker Symfony (PHP7-FPM - NGINX - PostgreSQL - ELK)

[![Build Status](https://travis-ci.org/maxpou/docker-symfony.svg?branch=master)](https://travis-ci.org/maxpou/docker-symfony)

Docker-symfony gives you everything you need for developing Symfony application. This complete stack run with docker and [docker-compose (1.7 or higher)](https://docs.docker.com/compose/).

## Routing

```bash
    get all /users
    get user /users/{id}
    get experiences of user /users/{id}/experiences
```

## Sources

API REST FOSRESTController : [Documentation](https://zestedesavoir.com/tutoriels/1280/creez-une-api-rest-avec-symfony-3/developpement-de-lapi-rest/fosrestbundle-et-symfony-a-la-rescousse/#2-routage-avec-fosrestbundle).

## Installation


1. Build/run containers with (with and without detached mode)

    ```bash
    $ docker-compose build
    $ docker-compose up -d
    ```

    1.1. Composer install & create database

        ```bash
        $ docker-compose exec php bash
        $ composer install
        # Symfony 3
        $ php bin/console  doctrine:database:create
        $ php bin/console  doctrine:schema:update --force
        $ php bin/console doctrine:fixtures:load # load fixtures
        # clear cache
        $ php bin/console cache:clear
        # premission on project
        $ sudo chmod -R 777 app/cache app/logs # Symfony 3
        $ HTTPDUSER=`ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
        $ setfacl -R -m u:$HTTPDUSER:rwX -m u:`whoami`:rwX var
        $ setfacl -dR -m u:$HTTPDUSER:rwX -m u:`whoami`:rwX var
        ```

5. Enjoy :-)

## Usage

Just run `docker-compose up -d`, then:

* Symfony app: visit [localhost:3001](http://localhost:3001) (ports 3001)
* Symfony dev mode: visit [localhost/app_dev.php](http://localhost:3001/app_dev.php) (ports 3001)
* Logs (Kibana): [localhost:81](http://localhost:81)
* Logs (files location): logs/nginx and logs/symfony

## Customize

If you want to add optionnals containers like Redis, PHPMyAdmin... take a look on [doc/custom.md](doc/custom.md).

## How it works?

Have a look at the `docker-compose.yml` file, here are the `docker-compose` built images:

* `db`: This is the MySQL database container,
* `php`: This is the PHP-FPM container in which the application volume is mounted,
* `nginx`: This is the Nginx webserver container in which application volume is mounted too,
* `elk`: This is a ELK stack container which uses Logstash to collect logs, send them into Elasticsearch and visualize them with Kibana.

This results in the following running containers:

```bash
$ docker-compose ps
           Name                          Command               State              Ports            
--------------------------------------------------------------------------------------------------
dockersymfony_db_1            /entrypoint.sh mysqld            Up      0.0.0.0:3306->3306/tcp      
dockersymfony_elk_1           /usr/bin/supervisord -n -c ...   Up      0.0.0.0:81->80/tcp          
dockersymfony_nginx_1         nginx                            Up      443/tcp, 0.0.0.0:3001->80/tcp
dockersymfony_php_1           php-fpm                          Up      0.0.0.0:9000->9000/tcp      
```

## Useful commands

```bash
# bash commands
$ docker-compose exec php bash

# Composer (e.g. composer update)
$ docker-compose exec php composer update

# SF commands (Tips: there is an alias inside php container)
$ docker-compose exec php php /var/www/symfony/app/console cache:clear # Symfony2
$ docker-compose exec php php /var/www/symfony/bin/console cache:clear # Symfony3
# Same command by using alias
$ docker-compose exec php bash
$ sf cache:clear

# Retrieve an IP Address (here for the nginx container)
$ docker inspect --format '{{ .NetworkSettings.Networks.dockersymfony_default.IPAddress }}' $(docker ps -f name=nginx -q)
$ docker inspect $(docker ps -f name=nginx -q) | grep IPAddress

# MySQL commands
$ docker-compose exec db mysql -uroot -p"root"

# F***ing cache/logs folder
$ sudo chmod -R 777 app/cache app/logs # Symfony2
$ sudo chmod -R 777 var/cache var/logs var/sessions # Symfony3

# Check CPU consumption
$ docker stats $(docker inspect -f "{{ .Name }}" $(docker ps -q))

# Delete all containers
$ docker rm $(docker ps -aq)

# Delete all images
$ docker rmi $(docker images -q)
```
