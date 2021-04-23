#!/bin/sh

docker-compose up -d
docker-compose exec app sh -c "composer install && chmod 777 -R var/* && php bin/console doctrine:schema:update --force"

xdg-open http://localhost:8072/
docker-compose exec app bash