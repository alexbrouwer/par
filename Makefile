DOCKER_COMPOSE_FILE=./docker-compose.yml
DOCKER_COMPOSE_DIR=./.docker
DOCKER_COMPOSE=docker-compose -f $(DOCKER_COMPOSE_FILE)

.PHONY: setup
setup: docker-init
	$(DOCKER_COMPOSE) run workspace composer install

workspace: docker-init
	$(DOCKER_COMPOSE) run workspace sh

watch-tests: docker-init
	$(DOCKER_COMPOSE) run workspace phpunit-watcher watch

.docker/.env:
	cp $(DOCKER_COMPOSE_DIR)/.env.example $(DOCKER_COMPOSE_DIR)/.env

.PHONY: docker-init
docker-init: .docker/.env
