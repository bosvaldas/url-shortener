# URL shortener

## Project setup

### Environment
```shell
cp .env.example .env
```
Add `GOOGLE_API_KEY` Google API key for https://developers.google.com/safe-browsing/v4/lookup-api

### Setup docker

```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

### Run project

```shell
vendor/bin/sail up -d
```

### Setup database

```shell
vendor/bin/sail artisan migrate
```

### Setup frontend

```shell
vendor/bin/sail npm install
vendor/bin/sail npm run build
```

### [Run the application](http://localhost:80)
