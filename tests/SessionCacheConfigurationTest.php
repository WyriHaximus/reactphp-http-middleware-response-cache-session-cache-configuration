<?php declare(strict_types=1);

namespace WyriHaximus\React\Tests\Http\Middleware;

use PHPUnit\Framework\TestCase;
use RingCentral\Psr7\Response;
use RingCentral\Psr7\ServerRequest;
use WyriHaximus\React\Http\Middleware\CacheConfiguration;
use WyriHaximus\React\Http\Middleware\Session;
use WyriHaximus\React\Http\Middleware\SessionCacheConfiguration;
use WyriHaximus\React\Http\Middleware\SessionId\RandomBytes;
use WyriHaximus\React\Http\Middleware\SessionMiddleware;

/**
 * @internal
 */
final class SessionCacheConfigurationTest extends TestCase
{
    public function testActiveRequestSession(): void
    {
        $session = new Session('', [], new RandomBytes());
        $session->begin();

        $request = (new ServerRequest('GET', 'https://example.com/'))->withAttribute(SessionMiddleware::ATTRIBUTE_NAME, $session);

        $cacheConfiguration = new SessionCacheConfiguration(new CacheConfiguration(['/']));

        self::assertFalse($cacheConfiguration->requestIsCacheable($request));
    }

    public function testInactiveRequestSession(): void
    {
        $session = new Session('', [], new RandomBytes());

        $request = (new ServerRequest('GET', 'https://example.com/'))->withAttribute(SessionMiddleware::ATTRIBUTE_NAME, $session);

        $cacheConfiguration = new SessionCacheConfiguration(new CacheConfiguration(['/']));

        self::assertTrue($cacheConfiguration->requestIsCacheable($request));
    }

    public function testActiveResponseSession(): void
    {
        $session = new Session('', [], new RandomBytes());
        $session->begin();

        $request = (new ServerRequest('GET', 'https://example.com/'))->withAttribute(SessionMiddleware::ATTRIBUTE_NAME, $session);
        $response = new Response();

        $cacheConfiguration = new SessionCacheConfiguration(new CacheConfiguration(['/']));

        self::assertFalse($cacheConfiguration->responseIsCacheable($request, $response));
    }

    public function testInactiveResponseSession(): void
    {
        $session = new Session('', [], new RandomBytes());

        $request = (new ServerRequest('GET', 'https://example.com/'))->withAttribute(SessionMiddleware::ATTRIBUTE_NAME, $session);
        $response = new Response();

        $cacheConfiguration = new SessionCacheConfiguration(new CacheConfiguration(['/']));

        self::assertTrue($cacheConfiguration->responseIsCacheable($request, $response));
    }
}
