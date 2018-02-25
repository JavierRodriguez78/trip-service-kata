<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class TripServiceTest extends TestCase
{
    private $tripService;

    protected function setUp()
    {
        $this->tripService = new TestableTripService();
    }

    /**
     * @test
     * @expectedException \TripServiceKata\Exception\UserNotLoggedInException
     */
    public function itShouldThrownAnExceptionWhenUserIsNotLoggedIn()
    {
        $user = new User('Mangel');
        $this->tripService->getTripsByUser($user);
    }
}

class TestableTripService extends TripService
{
    protected function getLoggedInUser()
    {
        return null;
    }
}

