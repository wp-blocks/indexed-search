#!/usr/bin/env bash

docker compose --file tests/docker-compose.yml --env-file tests/.env up --wait
docker compose --file tests/docker-compose.yml --env-file tests/.env exec -T wordpress chown -R www-data:www-data wp-content wp-content/plugins wp-content/plugins/indexed-search wp-content/plugins/indexed-search/tests wp-content/plugins/indexed-search/tests/_support wp-content/plugins/indexed-search/tests/_support/_generated wp-content/plugins/indexed-search/tests/_output
docker compose --file tests/docker-compose.yml --env-file tests/.env exec -T -w /var/www/html/wp-content/plugins/indexed-search wordpress bash bin/wp-install.sh
