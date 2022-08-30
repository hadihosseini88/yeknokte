<?php

namespace Hadihosseini88\User\Services;

class UserService
{
    public static function changePassword($user, $newPassword)
    {
        $user->password = bcrypt($newPassword);
        $user->save();
    }

}
