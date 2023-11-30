#!/usr/bin/env bash

./bin/test-up.sh
./bin/wait-for-it.sh http://localhost:$WORDPRESS_LOCALHOST_PORT
