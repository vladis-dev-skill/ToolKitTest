down: docker-down
up: docker-up
init: docker-down-clear docker-pull docker-build docker-up run-app
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

run-app: composer-install toolkit-generate-jwt toolkit-migrate toolkit-phpcs

composer-install:
	docker exec -it toolkit_php-fpm composer install

toolkit-generate-jwt:
	docker exec -it toolkit_php-fpm php bin/console lexik:jwt:generate-keypair --skip-if-exists

toolkit-migrate:
	docker exec -it toolkit_php-fpm php bin/console doctrine:migrations:migrate --no-interaction

toolkit-phpcs: toolkit-phpcs-mkdir toolkit-phpcs-composer
toolkit-phpcs-mkdir:
	docker exec -it toolkit_php-fpm mkdir -p --parents tools/php-cs-fixer
toolkit-phpcs-composer:
	docker exec -it toolkit_php-fpm composer require --no-interaction --working-dir=tools/php-cs-fixer friendsofphp/php-cs-fixer

toolkit-fixture:
	docker exec -it toolkit_php-fpm php bin/console doctrine:fixtures:load --no-interaction

toolkit-php-cs-fixer:
	docker exec -it toolkit_php-fpm tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src