.PHONY: help install dev up down db-reset key-generate migrate seed

help:
	@echo "Alfred App - Comandos de Desenvolvimento"
	@echo ""
	@echo "make install    - Instala as dependências (composer + npm)"
	@echo "make dev        - Inicia o servidor de desenvolvimento"
	@echo "make up         - Inicia os containers Docker"
	@echo "make down       - Para os containers Docker"
	@echo "make db-reset   - Reseta o banco de dados"
	@echo "make key-generate - Gera uma nova chave de aplicação"
	@echo "make migrate    - Executa as migrações"
	@echo "make seed       - Popula o banco de dados"

install:
	composer install
	cp .env.example .env
	php artisan key:generate

dev:
	php artisan serve --host=0.0.0.0

up:
	docker-compose up -d

down:
	docker-compose down

db-reset:
	php artisan migrate:fresh --seed

key-generate:
	php artisan key:generate

migrate:
	php artisan migrate

seed:
	php artisan db:seed
