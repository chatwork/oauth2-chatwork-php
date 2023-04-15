<?php

namespace ChatWork\OAuth2\Client;

use League\OAuth2\Client\OptionProvider\HttpBasicAuthOptionProvider;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

/**
 * @package ChatWork\OAuth2\Client
 */
final class ChatWorkProvider extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param string $redirectUri
     * @param array $collaborators
     */
    public function __construct(string $clientId, string $clientSecret, string $redirectUri = '', array $collaborators = [])
    {
        // use Basic Auth: https://developer.chatwork.com/docs/oauth#%E8%AA%8D%E8%A8%BC
        $collaborators += ['optionProvider' => new HttpBasicAuthOptionProvider()];

        parent::__construct(compact('clientId', 'clientSecret', 'redirectUri') , $collaborators);
    }

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
    protected function checkResponse(ResponseInterface $response, $data)
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
        return new ChatWorkResourceOwner(
            $response['account_id'],
            $response['room_id'],
            $response['name'],
            $response['chatwork_id'],
            $response['organization_id'],
            $response['organization_name'],
            $response['department'],
            $response['title'],
            $response['url'],
            $response['introduction'],
            $response['mail'],
            $response['tel_organization'],
            $response['tel_extension'],
            $response['tel_mobile'],
            $response['skype'],
            $response['facebook'],
            $response['twitter'],
            $response['avatar_image_url'],
            $response['login_mail']
        );
    }

    /**
     * @inheritdoc
     */
    protected function getScopeSeparator(): string
    {
        return ' ';
    }

}
