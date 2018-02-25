<?php

use PHPUnit\Framework\TestCase;
use TripServiceKata\User\User;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldInformWhenUsersAreNotFriends()
    {
        $user = new User('Bob');
        $friend = new User('John');
        $noFriend = new User('Mark');

        $user->addFriend($friend);

        $this->assertFalse($user->isFriendsWith($noFriend));
    }
}
