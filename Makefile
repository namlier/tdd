PHPUNIT := ./vendor/bin/phpunit

# phpunit Unit tests
.PHONY: test-unit
test-unit:
	$(PHPUNIT) -c phpunit.unit.xml --testdox

# phpunit Integration tests
.PHONY: test-integration
test-integration:
	$(MAKE) delete-integration-database
	$(MAKE) create-integration-database
	$(PHPUNIT) -c phpunit.integration.xml --testdox

.PHONY: test-coverage-merge
test-coverage-merge:
	php8.4 tools/phpcov merge coverage --html coverage/coverage-html

.PHONY: migrate
migrate:
	php8.4 migrations/migrate.php

.PHONY: create-integration-database
create-integration-database:
	APP_ENV=test php8.4 migrations/create-database.php

.PHONY: delete-integration-database
delete-integration-database:
	APP_ENV=test php8.4 migrations/delete-database.php
