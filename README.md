# Session aware cache configuration for [`wyrihaximus/react-http-middleware-response-cache`](https://github.com/WyriHaximus/reactphp-http-middleware-response-cache) 

[![Build Status](https://travis-ci.org/WyriHaximus/reactphp-http-middleware-response-cache-session-cache-configuration.svg?branch=master)](https://travis-ci.org/WyriHaximus/reactphp-http-middleware-response-cache-session-cache-configuration)
[![Latest Stable Version](https://poser.pugx.org/WyriHaximus/react-http-middleware-response-cache-session-cache-configuration/v/stable.png)](https://packagist.org/packages/WyriHaximus/react-http-middleware-response-cache-session-cache-configuration)
[![Total Downloads](https://poser.pugx.org/WyriHaximus/react-http-middleware-response-cache-session-cache-configuration/downloads.png)](https://packagist.org/packages/WyriHaximus/react-http-middleware-response-cache-session-cache-configuration)
[![Code Coverage](https://scrutinizer-ci.com/g/WyriHaximus/reactphp-http-middleware-response-cache-session-cache-configuration/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/WyriHaximus/reactphp-http-middleware-response-cache-session-cache-configuration/?branch=master)
[![License](https://poser.pugx.org/WyriHaximus/react-http-middleware-response-cache-session-cache-configuration/license.png)](https://packagist.org/packages/WyriHaximus/react-http-middleware-response-cache-session-cache-configuration)
[![PHP 7 ready](http://php7ready.timesplinter.ch/WyriHaximus/reactphp-http-middleware-response-cache-session-cache-configuration/badge.svg)](https://travis-ci.org/WyriHaximus/reactphp-http-middleware-response-cache-session-cache-configuration)

# Install

To install via [Composer](http://getcomposer.org/), use the command below, it will automatically detect 
the latest version and bind it with `^`.

```
composer require wyrihaximus/react-http-middleware-response-cache-session-cache-configuration
```

Cache configuration decorator for [`wyrihaximus/react-http-middleware-response-cache`](https://github.com/WyriHaximus/reactphp-http-middleware-response-cache) 
and [`wyrihaximus/react-http-middleware-session`](https://github.com/WyriHaximus/reactphp-http-middleware-session). When a request is going through that has 
an active session the cache is skipped and the request is passed to the next middleware in the chain. When a response is going through that has an active 
session the response won't be stored in the cache. The order of middleware is critical for the correct working of this cache configuration decorator. The 
example below shows the correct order.

# Usage

```php
$server = new Server([
    /** Other middleware */
    new SessionMiddleware('Floki'), // Note that the order here is important. The session middleware MUST attach the session before the ResponseCacheMiddleware 
    new ResponseCacheMiddleware(
        new SessionCacheConfiguration(
            new CacheConfiguration(
                [
                    '/',
                    '/robots.txt',
                    '/favicon.ico',
                    '/cache/***', // Anything that starts with /cache/ in the path will be cached
                    '/api/???', // Anything that starts with /cache/ in the path will be cached (query is included in the cache key)
                ],
                [ // Optional, array with headers to include in the cache
                    'Content-Type',
                ]
           )
        ),
        new ArrayCache() // Optional, will default to ArrayCache but any CacheInterface cache will work. 
    ),
    /** Other middleware */
]);
```

# License

The MIT License (MIT)

Copyright (c) 2018 Cees-Jan Kiewiet

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
