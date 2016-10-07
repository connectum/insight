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

    public static function track($event, $member = null, $properties = [])
    {
        if(is_null($member))
            static::trackBy($event, $member, $properties);

        static::redis()->zincrby($event, 1, $member);

        if(! empty($properties)) {
            collect($properties)->each(function($property, $key) use ($event, $member){
                static::redis()->zadd("$event:properties:$key:$property", 1, $member);
            });
        }
    }

    public static function trackBy($event, $member, $properties = [])
    {
        // member should be unique id
        static::redis()->sadd($event, $member);
    }

    /**
     * Format of the redis entry
     * ## > $prefix:$client_id:$date:$hour:$event_name
     *    prefix        => default prefix should be "insight"
     *    client_id     => unique identifier of the client (every stat is per client)
     *    date          => should be in following format "2016-10-07"
     *    hour          => is the hour when event has happened, for example "22"
     *    event_name    => is the name of the event, for example: "article_visits"
     *
     * Sorted set we use to track all visits for given event
     * ## > ZINCRBY insight:1:2016-10-07:17:article_visits, 1, $article_id
     *
     * To get all visits for given event
     * ## > ZSCORE insight:article_visits 16
     *
     * To get the number of members of sorted set
     * ## > ZCARD zscore insight:article_visits 18
     *
     * ## > SADD insight:2016-10-07-17:article_visits:list $article_id
     */

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
