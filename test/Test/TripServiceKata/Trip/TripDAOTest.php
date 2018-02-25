<?php

namespace TripServiceKata\Trip;

use PHPUnit\Framework\TestCase;
use TripServiceKata\User\User;

class TripDAOTest extends TestCase
{
    /**
     * @test
     * @expectedException \TripServiceKata\Exception\DependentClassCalledDuringUnitTestException
     */
    public function itShouldThrownAnExceptionWhenRetrievingUserTrips()
    {
        $tripDao = new TripDAO();

        $tripDao->tripsByUser(new User('John'));
    }
}
