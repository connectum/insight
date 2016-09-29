<?php

namespace Connectum\Insight;

use Predis\Client as Redis;

class Insight
{
    private static $redisClient = \Predis\Client::class;

    /**
     * @var Redis
     */
    private static $redis;

    public function __construct()
    {
        static::$redis = static::createRedisClient();
    }

    public static function count($key)
    {
        return static::$redis->scard($key);
    }

    public static function track($key, $value)
    {
        return static::$redis->sadd($key, $value);
    }

    public static function createRedisClient()
    {
        return new static::$redisClient;
    }

    public static function getClient()
    {
        return static::$redis;
    }
}
