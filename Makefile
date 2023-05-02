.DEFAULT_GOAL := check

.PHONY: check
check: lint test

.PHONY: test
test: vendor
	vendor/bin/phpunit

.PHONY: lint
lint: vendor
	vendor/bin/phpstan analyse -l 1 src tests

.PHONY: clean
clean:
	rm -rf vendor composer.lock

vendor: composer.lock
	composer install
	touch vendor

composer.lock:
	composer install

