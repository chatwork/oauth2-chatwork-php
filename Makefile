.PHONY: test
test:
	docker run --rm -v $(CURDIR):/app  -w /app php:7.1-cli php vendor/bin/phpunit
