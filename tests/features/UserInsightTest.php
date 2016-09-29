<?php

namespace Connectum\Tests\Insight\features;

use Connectum\Tests\Insight\TestCase;

class UserInsight extends TestCase
{
    public function testIfUserIsNotLoggedInCreateAnonymousUser()
    {
        $this->assertTrue(true);
    }

    /**
     * WALK WITH ME
     *
     * I'm on the /sign-up page
     * I'm not logged in
     * Insight needs to record my visit and every other visit I made on the site for the current session
     * I'll be assigned with an unique ID (UUID) and that ID will be used to link all my activities
     * When I finally log in, Insight will promote me as a standard user, and all activities linked to my anonymous UUID will
     *   be merged to the my User ID
     *
     * DAILY ACTIVE USERS - Summary
     *
     * To count unique users that logged in today, we set up a bitmap where each user is identified by an offset value
     *     redis.setbit(visit:yyyy-mm-dd, user_id, 1)
     */
}