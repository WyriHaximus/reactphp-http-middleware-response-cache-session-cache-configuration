<?php declare(strict_types=1);

namespace WyriHaximus\React\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SessionCacheConfiguration implements CacheConfigurationInterface
{
    /**
     * @var CacheConfigurationInterface
     */
    private $cacheConfiguration;

    public function __construct(CacheConfigurationInterface $cacheConfiguration)
    {
        $this->cacheConfiguration = $cacheConfiguration;
    }

    public function requestIsCacheable(ServerRequestInterface $request): bool
    {
        if (
            class_exists(SessionMiddleware::class) &&
            $request->getAttribute(SessionMiddleware::ATTRIBUTE_NAME) !== null &&
            $request->getAttribute(SessionMiddleware::ATTRIBUTE_NAME)->isActive() === true
        ) {
            return false;
        }

        return $this->cacheConfiguration->requestIsCacheable($request);
    }

    public function responseIsCacheable(ServerRequestInterface $request, ResponseInterface $response): bool
    {
        if (
            class_exists(SessionMiddleware::class) &&
            $request->getAttribute(SessionMiddleware::ATTRIBUTE_NAME) !== null &&
            $request->getAttribute(SessionMiddleware::ATTRIBUTE_NAME)->isActive() === true
        ) {
            return false;
        }

        return $this->cacheConfiguration->responseIsCacheable($request, $response);
    }

    public function cacheKey(ServerRequestInterface $request): string
    {
        return $this->cacheConfiguration->cacheKey($request);
    }

    public function cacheEncode(ResponseInterface $response): string
    {
        return $this->cacheConfiguration->cacheEncode($response);
    }

    public function cacheDecode(string $response): ResponseInterface
    {
        return $this->cacheConfiguration->cacheDecode($response);
    }
}
