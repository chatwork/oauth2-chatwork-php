# ChatWork Provider for OAuth 2.0 Client

[![Build Status](https://github.com/chatwork/oauth2-chatwork-php/actions/workflows/ci.yml/badge.svg)](https://github.com/chatwork/oauth2-chatwork-php/actions/workflows/ci.yml)
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

### Get an access token 

```php
$accessToken = $provider->getAccessToken((string) new AuthorizationCode(), [
    'code' => $code
]);
```

### Refresh a token 

```php
if ($accessToken->hasExpired()) {
    $refreshedAccessToken = $provider->getAccessToken((string) new RefreshToken(), [
        'refresh_token' => $accessToken->getRefreshToken()
    ]);
}
```

### Get resource owner's profile

```php
$resource_owner = $provider->getResourceOwner($accessToken);
```

## Example

[An example of ChatWork OAuth2 client](https://github.com/ada-u/chatwork-oauth2-client-example)

## ChatWork OAuth2.0 document

[API Document](http://developer.chatwork.com/ja/oauth.html)

## Blog

[チャットワークのOAuth2のクライアントをPHPで簡単に実装するためのライブラリを紹介](http://creators-note.chatwork.com/entry/2017/12/15/104133)

## Contributing

### Testing

```
$ make test
```

## License

The MIT License (MIT).
