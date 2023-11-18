SAIL=./vendor/bin/sail

all:
	make install
	make up
	make seed

install:
	make env
	docker run --rm \
        -u "$$(id -u):$$(id -g)" \
        -v $$(pwd):/var/www/html \
        -w /var/www/html \
        laravelsail/php81-composer:latest \
        composer install --ignore-platform-reqs

env:
	cp .env.example .env

up:
	$(SAIL) up -d

down:
	$(SAIL) down

seed:
	$(SAIL) artisan migrate:fresh --seed
