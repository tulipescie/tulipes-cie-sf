.DEFAULT_GOAL := help
CONSOLE=bin/console

.PHONY: help cc cc-prod watch perm clear clean

help:
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'

include .env

##
## Project setup
##===============

.env:		## Initializes .env file from .env.example
	@if [ ! -e .env ]; \
		then cp .env.example .env; \
	fi

install: 	## Installs frontend and backend dependencies
	make assets
	composer install

perm: 		## Fixes permissions for server-writeable directories
	chmod -R 775 var/cache
	chmod -R 775 var/logs

clear: 		## Clears frontend generated files
clear:
	rm -rf web/assets

clean: 		## Clear and remove dependencies
clean: clear
	rm -rf vendor node_modules

##
## Frontend
##==========
watch: 		## Launches frontend watching service
watch: node_modules
	yarn watch

assets:		## Builds frontend assets for *dev* environment
assets: node_modules
	yarn build

##
## Symfony
##=========

cc:		## Clears Symfony cache
	@if [ ! "$(APP_ENV)" ]; then \
		php $(CONSOLE) cache:clear -e=dev --no-warmup; \
	else \
		php $(CONSOLE) cache:clear -e=$(APP_ENV) --no-warmup; \
	fi

update-db:	## Updates database schema
	php $(CONSOLE) doctrine:schema:update --force

# rules
vendor: composer.lock
	composer install

composer.lock: composer.json
	@echo compose.lock is not up to date.

app/config/parameters.yml: app/config/parameters.yml.dist
	composer run-script post-install-cmd

node_modules: yarn.lock
	yarn install

yarn.lock: package.json
	@echo yarn.lock is not up to date.
