.PHONY: test
test: vendor
	vendor/bin/phpunit

.PHONY: clean
clean:
	rm -rf vendor composer.lock

vendor: composer.lock
	composer install
	touch vendor

composer.lock:
	composer install
