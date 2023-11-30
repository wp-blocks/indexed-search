#!/usr/bin/env bash

docker compose --file docker-compose.yml --env-file .env up --wait
docker compose --file docker-compose.yml --env-file .env exec -T wordpress chown www-data:www-data wp-content wp-content/plugins
