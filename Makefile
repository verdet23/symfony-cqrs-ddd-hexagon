# Executables (local)
DOCKER_COMP = docker compose

# Docker containers
PHP_CONT = $(DOCKER_COMP) exec -u 1000:1000 php

# Executables
PHP      = $(PHP_CONT) php
COMPOSER = $(PHP_CONT) composer
SYMFONY  = $(PHP_CONT) bin/console

#Misc
.DEFAULT_GOAL = help

.PHONY: help
.PHONY: vendor lint prepare-tests prepare-dev
.PHONY: tests tests-unit tests-integration tests-functional tests-dev

help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Project 🐳 ————————————————————————————————————————————————————————————————

vendor: composer.json composer.lock ## Install vendors
	composer install
	composer bin all update

lint: ## Lint yaml files and templates
	bin/console lint:yaml config/ --parse-tags
	bin/console lint:twig templates/


prepare-tests: ## Prepare test env - clear cache, reset DB
	bin/console cache:clear --env=test
	bin/console doctrine:database:drop --force --env=test || true
	bin/console doctrine:database:create --env=test
	bin/console doctrine:migrations:migrate -n --env=test
	bin/console sylius:fixtures:load -n --env=test

prepare-dev: ## Prepare dev env - clear cache, reset DB
	bin/console cache:clear --env=dev
	bin/console doctrine:database:drop --force --env=dev || true
	bin/console doctrine:database:create --env=dev
	bin/console doctrine:migrations:migrate -n --env=dev
	bin/console sylius:fixtures:load -n --env=dev


tests: prepare-tests ## Run PHPUnit all tests with coverage
	XDEBUG_MODE=coverage  bin/phpunit --coverage-html coverage-html

tests-unit: prepare-tests ## Run PHPUnit unit tests
	vendor/bin/phpunit --testsuite unit

tests-integration: prepare-tests ## Run PHPUnit integration
	vendor/bin/phpunit --testsuite integration

tests-functional: prepare-tests  ## Run PHPUnit functional
	vendor/bin/phpunit --testsuite functional

tests-dev:  ## Run PHPUnit functional - group dev
	vendor/bin/phpunit --group=dev

composer-validate: ## Validate composer cfg
	composer validate --no-check-publish

bin/local-php-security-checker: ## Download security checker
	mkdir -p $(@D)
	curl -LS https://github.com/fabpot/local-php-security-checker/releases/download/v1.0.0/local-php-security-checker_1.0.0_linux_amd64 -o $@
	chmod +x $@

security-tests: bin/local-php-security-checker ## Run security checker
	bin/local-php-security-checker

clean: ## Rm vendors
	rm -rf build/ vendor/ bin/local-php-security-checker vendor-bin/*/vendor/*

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
build: ## Builds the Docker images
	@$(DOCKER_COMP) -f docker-compose.yml -f docker-compose.override.yml build --pull --no-cache

up: ## Start the docker hub
	@$(DOCKER_COMP) -f docker-compose.yml -f docker-compose.override.yml up

down: ## Stop the docker hub
	@$(DOCKER_COMP) down --remove-orphans

sh: ## Connect to the PHP FPM container
	@$(PHP_CONT) sh
