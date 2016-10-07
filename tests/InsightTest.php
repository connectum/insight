<?php

namespace Connectum\Tests\Insight;

use Predis\Client;
use Connectum\Insight\Insight;
use Illuminate\Support\Facades\Redis;

class InsightTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testClientIsAnInstanceOfPredisClient()
    {
        $this->assertInstanceOf(Client::class, Insight::redis());
    }

    public function testIfWeCanTrackAnEvent()
    {
        Insight::track('test', 1);

        $actual = Redis::scard('test');

        $this->assertEquals(1, $actual);

        Redis::del('test');
    }

    public function testEventCount()
    {
        Insight::track('test', 1);

        $this->assertEquals(1, Insight::count('test'));

        Redis::del('test');
    }
}