<?php

namespace Connectum\Tests\Insight;

use Illuminate\Support\Facades\Redis;
use Predis\Client;
use Connectum\Insight\Insight;

class InsightTest extends TestCase
{
    protected $insight;

    public function setUp()
    {
        parent::setUp();
        $this->insight = new Insight();
    }

    public function testClientIsAnInstanceOfPredisClient()
    {
        $this->assertInstanceOf(Client::class, $this->insight->getClient());
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
        $this->insight->track('test', 1);

        $this->assertEquals(1, Insight::count('test'));

        Redis::del('test');
    }
}