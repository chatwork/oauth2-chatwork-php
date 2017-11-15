<?php

namespace ChatWork\OAuth2\Client\Test;

use ChatWork\OAuth2\Client\ChatWorkProvider;
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
}
