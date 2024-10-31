up:
	docker compose up -d
down:
	docker compose down --remove-orphans
down-volumes:
	docker compose down --remove-orphans -v
up-build:
	docker compose up -d --build
init: down-volumes up-build