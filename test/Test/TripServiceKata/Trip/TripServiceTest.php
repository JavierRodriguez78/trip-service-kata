<?php

namespace Test\TripServiceKata\Trip;

use function is_array;
use PHPUnit\Framework\TestCase;
use TripServiceKata\Trip\Trip;
use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class TripServiceTest extends TestCase
{
    private $tripService;

    /**
     * @test
     * @expectedException \TripServiceKata\Exception\UserNotLoggedInException
     */
    public function itShouldThrownAnExceptionWhenUserIsNotLoggedIn()
    {
        $tripService = new TestableTripService(null);
        $user = new User('Bob');
        $tripService->getTripsByUser($user);
    }

    /**
     * @test
     */
    public function itShouldNotReturnAnyTripsWhenUsersAreNotFriends()
    {
        $loggedInUser = new User('Joe');
        $friend = new User('Jack');
        $loggedInUser->addFriend($friend);
        $japanTrip = new Trip();
        $loggedInUser->addTrip($japanTrip);

        $otherUser = new User('Marshall');
        $tripService = new TestableTripService($loggedInUser);
        $trips = $tripService->getTripsByUser($otherUser);

        $this->assertTrue(is_array($trips));
        $this->assertEmpty($trips);
    }

    /**
     * @test
     */
    public function itShouldReturnFriendTripsWhenUsersAreFriend()
    {
        $loggedInUser = new User('Joe');
        $friend = new User('Jack');
        $friend->addFriend($loggedInUser);

        $japanTrip = new Trip();
        $loggedInUser->addTrip($japanTrip);
        $scotlandTrip = new Trip();
        $loggedInUser->addTrip($scotlandTrip);

        $tripService = new TestableTripService($loggedInUser);
        $trips = $tripService->getTripsByUser($friend);

        $this->assertEquals(2, count($trips));
    }
}

class TestableTripService extends TripService
{
    private $loggedInUser;

    public function __construct(User $loggedInUser = null)
    {
        $this->loggedInUser = $loggedInUser;
    }

    protected function getLoggedInUser()
    {
        return $this->loggedInUser;
    }
}

