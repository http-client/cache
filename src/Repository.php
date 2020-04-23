<?php

namespace HttpClient\Cache;

use Closure;

class Repository
{
    use ResolvesCache;

    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function remember($key, $ttl, Closure $callback)
    {
        $value = $this->resolveCache()->get($key);

        if (! is_null($value)) {
            return $value;
        }

        $this->resolveCache()->set($key, $value = $callback(), $ttl);

        return $value;
    }
}
