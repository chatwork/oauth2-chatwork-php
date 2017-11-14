.PHONY: composer-install
composer-install:
	docker run --rm -v $(CURDIR):/app composer/composer install
