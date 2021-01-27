<?php

namespace ChatWork\OAuth2\Client\Test;

require 'vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

use ChatWork\OAuth2\Client\ChatWorkProvider;
use League\OAuth2\Client\Grant\AuthorizationCode;
use PHPUnit\Framework\TestCase;

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

        $assertions = \GuzzleHttp\Middleware::tap(function (\Psr\Http\Message\RequestInterface $request, $options) use ($expectedToken) {
            parse_str($request->getBody()->getContents(), $param);
            assertArrayNotHasKey('client_id', $param);
            assertArrayNotHasKey('client_secret', $param);
            assertEquals("Basic {$expectedToken}", $request->getHeader('Authorization')[0]);
        });
        $stack = \GuzzleHttp\HandlerStack::create();
        $stack->push($assertions);
        $client = new \GuzzleHttp\Client(['handler' => $stack]);

        $provider = new ChatWorkProvider(
            $clientId, 
            $clientSecret, 
            'https://example.com/',
            [
                'httpClient' => $client
            ]
        );
        
        $provider->getAccessToken(new AuthorizationCode(), ['code' => 'authorization_code']);
    }
}
