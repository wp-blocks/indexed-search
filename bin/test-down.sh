#!/usr/bin/env bash

docker compose --file tests/docker-compose.yml --env-file tests/.env down
