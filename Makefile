up:
	docker compose up -d

down:
	docker compose down --remove-orphans

down-volumes:
	docker compose down --remove-orphans -v

up-build:
	docker compose up -d --build

init: down-volumes up-build migrate messenger-prepare

migrate:
	docker compose exec api-php-fpm bin/console --no-interaction doctrine:migrations:migrate

messenger-prepare:
	docker compose exec api-php-fpm bin/console --no-interaction messenger:setup-transports

consume:
	docker compose exec api-php-fpm bin/console messenger:consume -vv

stan:
	docker compose exec api-php-fpm vendor/bin/phpstan analyse src

test:
	docker compose exec api-php-fpm bin/phpunit