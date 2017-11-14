<?php

namespace ChatWork\OAuth2\Client;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

/**
 * @package ChatWork\OAuth2\Client
 */
final class ChatWorkProvider extends AbstractProvider
{

    /**
     * @inheritdoc
     */
    public function getBaseAuthorizationUrl(): string
    {
        return 'https://www.chatwork.com/packages/oauth2/login.php';
    }

    /**
     * @inheritdoc
     */
    public function getBaseAccessTokenUrl(array $params): string
    {
        return 'https://oauth.chatwork.com/token';
    }

    /**
     * @inheritdoc
     * @see http://developer.chatwork.com/ja/endpoint_me.html
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return 'https://api.chatwork.com/v2/me';
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultScopes(): array
    {
        return ['users.profile.me:read'];
    }

    /**
     * @inheritdoc
     */
    protected function checkResponse(ResponseInterface $response, $data): void
    {
        if (isset($data['error'])) {
            throw new IdentityProviderException(
                sprintf(
                    'error: %s, error_description: %s, error_uri: %s',
                    isset($data['error']) ? $data['error'] : '',
                    isset($data['error_description']) ? $data['error_description'] : '',
                    isset($data['error_uri']) ? $data['error_uri'] : ''
                ),
                $response->getStatusCode(),
                $response
            );
        }
    }

    /**
     * @inheritdoc
     */
    protected function createResourceOwner(array $response, AccessToken $token): ResourceOwnerInterface
    {
        // TODO: Implement createResourceOwner() method.
    }
}
