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
        // TODO: Implement getBaseAuthorizationUrl() method.
    }

    /**
     * @inheritdoc
     */
    public function getBaseAccessTokenUrl(array $params): string
    {
        // TODO: Implement getBaseAccessTokenUrl() method.
    }

    /**
     * @inheritdoc
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        // TODO: Implement getResourceOwnerDetailsUrl() method.
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultScopes(): array
    {
        // TODO: Implement getDefaultScopes() method.
    }

    /**
     * @inheritdoc
     */
    protected function checkResponse(ResponseInterface $response, $data): void
    {
        // TODO: Implement checkResponse() method.
    }

    /**
     * @inheritdoc
     */
    protected function createResourceOwner(array $response, AccessToken $token): ResourceOwnerInterface
    {
        // TODO: Implement createResourceOwner() method.
    }
}
