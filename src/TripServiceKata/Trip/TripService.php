<?php

namespace TripServiceKata\Trip;

use TripServiceKata\User\User;
use TripServiceKata\Exception\UserNotLoggedInException;

class TripService
{
    private $tripDAO;

    public function __construct(TripDAO $tripDAO)
    {
        $this->tripDAO = $tripDAO;
    }

    public function getTripsByUser(User $user, User $loggedUser = null)
    {
        if (null === $loggedUser) {
            throw new UserNotLoggedInException();
        }

        return $user->isFriendsWith($loggedUser)
            ? $tripList = $this->tripsByUser($user)
            : array();
    }

    protected function tripsByUser(User $user): array
    {
        return $this->tripDAO->tripsByUser($user);
    }
}

