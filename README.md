# Laravel + Docker

Конфиг:
- переименовать ".env.example" в ".env"

Запуск:
- docker-compose up --build -d
- docker exec docker_php_1 composer update
- docker exec docker_php_1 npm update
- docker exec docker_php_1 php artisan key:generate

Получить IP контейнеров:
- docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' docker_mariadb_1
- docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' docker_redis_1
- docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' docker_rabbitmq_1
- указать ip контейнеров в конфиге ".env"

Создаем базу данных:
- docker exec -i -t docker_mariadb_1 /bin/bash
- mysql -u root -p
- CREATE DATABASE laravel;
- docker exec docker_php_1 php artisan migrate

Запустить worker rabbitmq:
- docker exec docker_php_1 php artisan queue:work

Проект заработает по адресу http://localhost/

Запуск тестов:
- docker exec docker_php_1 php artisan test
