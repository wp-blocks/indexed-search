# Indexed Search

An advanced WordPress indexed search plugin.

## Description

A super cool search plugin which uses indexing to make the search of post content speedy!

## Development

### Getting started

The testing environment setup in a container through Docker.

```sh
# Command to start the testing WordPress instance.
docker-compose up -d
```

### Testing database

The testing container does not persist volumes. If a local database dump exists, it will be loaded when initializing the database container.

Use the following command to create a local database dump.

```sh
# Command to dump the testing database to tests/_data/dump.sql
bin/dump-acceptance-db
```
