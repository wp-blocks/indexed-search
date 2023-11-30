docker compose --file tests/docker-compose.yml --env-file tests/.env exec -T -w /var/www/html/wp-content/plugins/indexed-search wordpress ./vendor/bin/codecept build
