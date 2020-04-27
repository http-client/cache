<?php

namespace HttpClient\Cache;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

trait ResolvesCache
{
    /**
     * @var \Psr\SimpleCache\CacheInterface
     */
    protected $cache;

    /**
     * @var callable
     */
    protected $resolveCacheUsing;

    /**
     * @return $this
     */
    public function resolveCacheUsing(callable $callback)
    {
        $this->resolveCacheUsing = $callback;

        return $this;
    }

    /**
     * @return \Psr\SimpleCache\CacheInterface
     */
    protected function resolveCache()
    {
        return $this->cache ?: $this->cache = call_user_func($this->resolveCacheUsing ?: function () {
            return new Psr16Cache(new FilesystemAdapter('http-client', 1500));
        });
    }
}
