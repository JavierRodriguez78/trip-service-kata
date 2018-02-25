<?php

namespace Test\TripServiceKata\Trip;

use function is_array;
use PHPUnit\Framework\TestCase;
use TripServiceKata\Trip\Trip;
use TripServiceKata\Trip\TripDAO;
use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class TripServiceTest extends TestCase
{
    /**
     * @test
     * @expectedException \TripServiceKata\Exception\UserNotLoggedInException
     */
    public function itShouldThrownAnExceptionWhenUserIsNotLoggedIn()
    {
        $tripDao = $this->getMockBuilder(TripDAO::class)
            ->getMock();

        $tripService = new TripService($tripDao);
        $loggedInUser = null;
        $user = new User('Bob');
        $tripService->getTripsByUser($user, null);
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

        $tripDao = $this->getMockBuilder(TripDAO::class)
            ->setMethods(['tripsByUser'])
            ->getMock();
        $tripDao
            ->expects($this->any())
            ->method('tripsByUser')
            ->willReturn([]);

        $tripService = new TripService($tripDao);
        $trips = $tripService->getTripsByUser($otherUser, $loggedInUser);

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
        $friend->addTrip($japanTrip);
        $scotlandTrip = new Trip();
        $friend->addTrip($scotlandTrip);

        $tripDao = $this->getMockBuilder(TripDAO::class)
            ->setMethods(['tripsByUser'])
            ->getMock();

        $tripDao
            ->expects($this->any())
            ->method('tripsByUser')
            ->willReturn([$scotlandTrip, $japanTrip]);

        $tripService = new TripService($tripDao);
        $trips = $tripService->getTripsByUser($friend, $loggedInUser);

        $this->assertEquals(2, count($trips));
    }
}
