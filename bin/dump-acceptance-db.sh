#!/usr/bin/env bash

docker compose --file tests/docker-compose.yml --env-file tests/.env exec database /usr/bin/mysqldump -uwordpress -pwordpress wordpress > tests/_data/dump.sql
