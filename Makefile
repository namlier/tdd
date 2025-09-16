PHPUNIT := ./vendor/bin/phpunit

# phpunit Unit tests
.PHONY: test-unit
test-unit:
	$(PHPUNIT) -c phpunit.unit.xml --testdox

# phpunit Integration tests
.PHONE: test-integration
test-integration:
	$(PHPUNIT) -c phpunit.integration.xml --testdox