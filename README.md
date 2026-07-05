# Kislist Recrutation Task

## First Steps
Setup and start application in dev mode
```shell script
docker compose build
```

```shell script
docker compose run --rm app composer install
docker compose up -d
```

Main container
```shell script
docker compose exec -it app bash 
```

## Makefile
Run tests
```shell script
make test
```
