# Indexed Search

An advanced WordPress indexed search plugin.

## Description

A super cool search plugin which uses indexing to make the search of post content speedy!

## Development

### Getting started

The development environment is setup in a Docker container.

```sh
# Create a development environment file
cp .env.example .env

# Command to start the development WordPress instance.
docker-compose up -d
```

## Testing

The development environment is setup in a separate Docker container than development.

```sh
# Create a testing environment file
cp tests/.env.example tests/.env

# Command to start the testing WordPress instance.
bin/test-up.sh

# Command to run Codeception unit tests from inside the container.
bin/test-run.sh unit

# Command to run Codeception acceptance tests from outside the container.
vendor/bin/codecept run acceptance
```

### Testing database

The testing container does not persist volumes. If a local database dump exists, it will be loaded when initializing the database container.

Use the following command to create a local database dump.

```sh
# Command to dump the testing database to tests/_data/dump.sql
bin/dump-acceptance-db.sh
```
