# Makefile

include .env

# Check if Sail is available in the current directory (usually installed via Composer)
SAIL = ./vendor/bin/sail

# Start the containers with Sail
up:
	$(SAIL) up -d

# Stop the containers with Sail
down:
	$(SAIL) down

# Run bash inside the container using Sail
bash:
	$(SAIL) shell

# Build the containers using Sail (useful for rebuilding images)
build:
	$(SAIL) build

# Run Composer inside the container using Sail
composer:
	$(SAIL) composer $(args)

# Run Artisan commands inside the container using Sail
artisan:
	$(SAIL) artisan $(args)

# Run npm commands inside the container using Sail
npm:
	$(SAIL) npm $(args)

# Run to install the application
install:
	composer install
	npm install
	php artisan key:generate
	php artisan sail:install
	$(SAIL) up -d
	$(SAIL) artisan app:install
	npm run dev
