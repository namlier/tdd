PHPUNIT := ./vendor/bin/phpunit

# phpunit Unit tests
.PHONY: test-unit
test-unit:
	$(PHPUNIT) -c phpunit.unit.xml --testdox

# phpunit Integration tests
.PHONY: test-integration
test-integration:
	$(PHPUNIT) -c phpunit.integration.xml --testdox

.PHONY: migrate
migrate:
	php8.4 migrations/migrate.php

.PHONY: migrate-tests
migrate-tests:
	APP_ENV=test php8.4 migrations/migrate.php

.PHONY: coverage
coverage:
	php8.4 vendor/bin/phpunit --coverage-html=coverage --configuration=phpunit.unit.xml