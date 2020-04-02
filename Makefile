DOCKER_COMPOSE_FILE=./docker-compose.yml
DOCKER_COMPOSE=docker-compose -f $(DOCKER_COMPOSE_FILE)

build: docker-init
	$(DOCKER_COMPOSE) build

workspace: docker-init
	$(DOCKER_COMPOSE) run workspace sh

watch-tests: docker-init
	$(DOCKER_COMPOSE) run workspace phpunit-watcher watch

##@ [Docker] Build / Infrastructure
.docker/.env:
	cp $(DOCKER_COMPOSE_DIR)/.env.example $(DOCKER_COMPOSE_DIR)/.env

.PHONY: docker-init
docker-init: .docker/.env ## Make sure the .env file exists for docker
