test:
	bin/console --env=test c:c
	bin/console doctrine:database:create --env=test --if-not-exists
	bin/console doctrine:migrations:migrate --env=test --no-interaction
	bin/phpunit