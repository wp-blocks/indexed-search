#!/usr/bin/env bash

docker compose --file tests/docker-compose.yml --env-file tests/.env up --wait
docker compose --file tests/docker-compose.yml --env-file tests/.env exec -T wordpress chown -R www-data:www-data wp-content wp-content/plugins wp-content/plugins/indexed-search
docker compose --file tests/docker-compose.yml --env-file tests/.env exec -T -w /var/www/html/wp-content/plugins/indexed-search wordpress bash bin/wp-install.sh
