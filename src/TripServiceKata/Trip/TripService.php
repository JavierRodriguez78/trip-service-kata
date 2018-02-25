<?php

namespace TripServiceKata\Trip;

use TripServiceKata\User\User;
use TripServiceKata\Exception\UserNotLoggedInException;

class TripService
{
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
        return TripDAO::findTripsByUser($user);
    }
}

