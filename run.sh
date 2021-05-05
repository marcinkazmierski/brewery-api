#!/bin/sh

docker-compose up -d
docker-compose exec app sh -c "composer install && chmod 777 -R var/*"

xdg-open http://localhost:8072/
docker-compose exec app bash