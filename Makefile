# Atajos para gestionar el proyecto con Docker

APP=clinica-botanica-app
DB=clinica-botanica-db

.PHONY: build up down logs ps sh bash artisan migrate seed key link cache fresh

build:
	docker compose build

up:
	docker compose up -d

down:
	docker compose down

logs:
	docker compose logs -f $(APP)

ps:
	docker compose ps

sh:
	docker compose exec $(APP) sh || true

bash:
	docker compose exec $(APP) bash || true

artisan:
	# uso: make artisan cmd="migrate --force"
	docker compose exec $(APP) php artisan $(cmd)

migrate:
	docker compose exec $(APP) php artisan migrate --force

seed:
	docker compose exec $(APP) php artisan db:seed --force

key:
	docker compose exec $(APP) php artisan key:generate --show

link:
	docker compose exec $(APP) php artisan storage:link || true

cache:
	docker compose exec $(APP) sh -lc 'php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan config:cache && php artisan route:cache'

fresh:
	docker compose exec $(APP) php artisan migrate:fresh --seed --force
