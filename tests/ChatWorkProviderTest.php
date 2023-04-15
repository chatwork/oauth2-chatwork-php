<?php

namespace ChatWork\OAuth2\Client\Test;

use ChatWork\OAuth2\Client\ChatWorkProvider;
use League\OAuth2\Client\Grant\AuthorizationCode;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

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

        $assert = function (RequestInterface $request) use ($expectedToken) {
            parse_str($request->getBody()->getContents(), $param);
            assertArrayNotHasKey('client_id', $param,       'request body should not contains "client_id".');
            assertArrayNotHasKey('client_secret', $param,   'request body should not contains "client_secret" too.');
            assertEquals("Basic {$expectedToken}", $request->getHeader('Authorization')[0], 'client MUST use Basic Authentication');
            throw new \Exception('OK'); // stop before send request
        };

        $this->expectExceptionMessage('OK');

        $provider = new ChatWorkProvider(
            $clientId, 
            $clientSecret, 
            'https://example.com/',
            [
                'httpClient' => $this->createSpyClient($assert)
            ]
        );
        
        $provider->getAccessToken(new AuthorizationCode(), ['code' => 'authorization_code']);
    }

    private function createSpyClient(callable $assetion)
    {
        $stack = \GuzzleHttp\HandlerStack::create();
        $stack->push(\GuzzleHttp\Middleware::tap($assetion));
        return new \GuzzleHttp\Client(['handler' => $stack]);
    }
    
}
