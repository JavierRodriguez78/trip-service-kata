<?php

namespace TripServiceKata\Trip;

use TripServiceKata\User\User;
use TripServiceKata\User\UserSession;
use TripServiceKata\Exception\UserNotLoggedInException;

class TripService
{
    public function getTripsByUser(User $user)
    {
        $tripList = array();
        $loggedUser = $this->getLoggedInUser();
        $isFriend = false;

        if ($loggedUser != null) {
            foreach ($user->getFriends() as $friend) {
                if ($friend == $loggedUser) {
                    $isFriend = true;
                    break;
                }
            }

            if ($isFriend) {
                $tripList = $this->tripsByUser($user);
            }

            return $tripList;
        } else {
            throw new UserNotLoggedInException();
        }
    }

    protected function getLoggedInUser()
    {
        return UserSession::getInstance()->getLoggedUser();
    }

    /**
     * @param User $user
     */
    protected function tripsByUser(User $user)
    {
        return TripDAO::findTripsByUser($user);
    }
}
