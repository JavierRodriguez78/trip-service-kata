<?php

namespace TripServiceKata\Trip;

use TripServiceKata\User\User;
use TripServiceKata\User\UserSession;
use TripServiceKata\Exception\UserNotLoggedInException;

class TripService
{
    public function getTripsByUser(User $user)
    {
        $loggedUser = $this->getLoggedInUser();

        if (null === $loggedUser) {
            throw new UserNotLoggedInException();
        }

        return $user->isFriendsWith($loggedUser)
            ? $tripList = $this->tripsByUser($user)
            : array();
    }

    protected function getLoggedInUser(): ?User
    {
        return UserSession::getInstance()->getLoggedUser();
    }

    protected function tripsByUser(User $user): array
    {
        return TripDAO::findTripsByUser($user);
    }
}

