#!/usr/bin/env bash

docker compose --file tests/docker-compose.yml --env-file tests/.env up --wait
docker compose --file tests/docker-compose.yml --env-file tests/.env exec -T wordpress chown www-data:www-data wp-content wp-content/plugins
