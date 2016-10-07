<?php

namespace Connectum\Insight;

class Insight
{
    private static $redisClientClass = \Predis\Client::class;

    /**
     * @var Predis client instance
     */
    private static $redis;

    public function __construct()
    {
    }

    public static function count($key)
    {
        return static::redis()->scard($key);
    }

    public static function track($key, $value)
    {
        return static::redis()->sadd($key, $value);
    }

    /**
     * Return an instance of a Predis Client
     *
     * @return mixed | \Predis\Client
     */
    public static function getRedisClient()
    {
        if(static::$redis === null) {
            static::$redis = new static::$redisClientClass;
        }

        return static::$redis;
    }

    /**
     * Just an alias of the getRedisClient()
     *
     * @return mixed
     */
    public static function redis()
    {
        return static::getRedisClient();
    }
}
