.PHONY: test
test: vendor composer.lock
	vendor/bin/phpunit

.PHONY: setup
setup:
	composer install

.PHONY: clean
clean:
	rm -rf vendor composer.lock

composer.lock: setup
vendor: setup

