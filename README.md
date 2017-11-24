# ChatWork Provider for OAuth 2.0 Client

[![Build Status](https://travis-ci.com/chatwork/oauth2-chatwork-php.svg?token=vkLmxw1KM6EiS5fWoyu8&branch=master)](https://travis-ci.com/chatwork/oauth2-chatwork-php)
[![Latest Stable Version](https://poser.pugx.org/chatwork/oauth2-chatwork/version)](https://packagist.org/packages/chatwork/oauth2-chatwork)
[![License](https://poser.pugx.org/chatwork/oauth2-chatwork/license)](https://packagist.org/packages/chatwork/oauth2-chatwork)


## Installation

```
composer require chatwork/oauth2-chatwork
```


## Usage

### Get our consent page URL

```php
$provider = new ChatWorkProvider(
    getenv('OAUTH2_CLIENT_ID'),
    getenv('OAUTH2_CLIENT_SECRET'),
    getenv('OAUTH2_REDIRECT_URI')
);

$url = $provider->getAuthorizationUrl([
    'scope' => ['users.all:read', 'rooms.all:read_write']
]);
```

### Get access token 

```php
$accessToken = $provider->getAccessToken((string) new AuthorizationCode(), [
    'code' => $code
]);
```

### Refresh access token 

```php
if ($accessToken->hasExpired()) {
    $refreshedAccessToken = $provider->getAccessToken('refresh_token', [
        'refresh_token' => $accessToken->getRefreshToken()
    ]);
}
```

### Get resource owner's profile

```php
$resource_owner = $provider->getResourceOwner($accessToken);
```

## Contributing

### Testing

```
$ make test
```

## License

The MIT License (MIT).
