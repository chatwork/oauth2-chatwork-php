<?php

namespace ChatWork\OAuth2\Client\Test;

use ChatWork\OAuth2\Client\ChatWorkProvider;
use League\OAuth2\Client\Grant\AuthorizationCode;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class Rejection extends \RuntimeException {}

/**
 * @package ChatWork\OAuth2\Client\Test
 */
class ChatWorkProviderTest extends TestCase
{

    /**
     * @test
     */
    public function getAuthorizationUrl_containsRequiredParameters()
    {
        $provider = (new ChatWorkProvider('testClientId', 'secret', 'https://example.com'));
        $url = $provider->getAuthorizationUrl();
        parse_str(parse_url($url, PHP_URL_QUERY), $query);

        $this->assertArrayHasKey('client_id', $query);
        $this->assertArrayHasKey('redirect_uri', $query);
        $this->assertArrayHasKey('state', $query);
        $this->assertArrayHasKey('scope', $query);
        $this->assertArrayHasKey('response_type', $query);

        $this->assertNotNull($provider->getState());
    }

    /**
     * @test
     */
    public function getAccessToken_willSendClientIdByHeader()
    {
        $clientId       = 'test_client_id';
        $clientSecret   = 'test_client_secret';
        $expectedToken  = base64_encode("{$clientId}:{$clientSecret}");

        $actualParam  = [];
        $actualHeader = [];

        $capturer = function (RequestInterface $request) use (&$actualParam, &$actualHeader) {
            parse_str($request->getBody()->getContents(), $actualParam);
            $actualHeader = $request->getHeader('Authorization');
            throw new Rejection; // stop before send request
        };

        $provider = new ChatWorkProvider(
            $clientId,
            $clientSecret,
            'https://example.com/',
            [
                'httpClient' => $this->createSpyClient($capturer)
            ]
        );

        try {
            $provider->getAccessToken(new AuthorizationCode(), ['code' => 'authorization_code']);
        } catch (Rejection $_) {
            // OK
        }

        $this->assertArrayHasKey('redirect_uri', $actualParam);
        $this->assertArrayHasKey('grant_type', $actualParam);
        $this->assertArrayHasKey('code', $actualParam);
        $this->assertArrayNotHasKey('client_id', $actualParam,       'request body should not contains "client_id".');
        $this->assertArrayNotHasKey('client_secret', $actualParam,   'request body should not contains "client_secret" too.');
        $this->assertEquals("Basic {$expectedToken}", $actualHeader[0], 'client MUST use Basic Authentication');
    }

    private function createSpyClient(callable $assetion)
    {
        $stack = \GuzzleHttp\HandlerStack::create();
        $stack->push(\GuzzleHttp\Middleware::tap($assetion));
        return new \GuzzleHttp\Client(['handler' => $stack]);
    }

}
