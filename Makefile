down: docker-down
up: docker-up
init: docker-down-clear docker-pull docker-build docker-up
exec_bash: docker-exec-bash
test: toolkit-test

toolkit-test:
	docker exec -it toolkit_php-fpm php bin/phpunit

docker-up:
	docker-compose -f docker_toolkit/docker-compose.yml up -d

docker-down:
	docker-compose -f docker_toolkit/docker-compose.yml down --remove-orphans

docker-down-clear:
	docker-compose -f docker_toolkit/docker-compose.yml down -v --remove-orphans

docker-pull:
	docker-compose -f docker_toolkit/docker-compose.yml pull

docker-build:
	docker-compose -f docker_toolkit/docker-compose.yml build

docker-exec-bash:
	docker exec -it toolkit_php-fpm bash

#Run app
