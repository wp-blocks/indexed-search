#!/usr/bin/env bash

docker compose --file tests/docker-compose.yml --env-file tests/.env up -d
./bin/wait-for-it.sh http://localhost:5389
docker compose --file tests/docker-compose.yml --env-file tests/.env exec -T wordpress chown www-data:www-data wp-content wp-content/plugins
docker compose --file tests/docker-compose.yml --env-file tests/.env exec -T -w /var/www/html/wp-content/plugins/indexed-search wordpress bash bin/wp-install.sh
