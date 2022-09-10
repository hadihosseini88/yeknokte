<?php

namespace Hadihosseini88\User\Repositories;

use Hadihosseini88\User\Models\User;

class UserRepo
{
    public function findByEmail($email){
        return User::query()->where('email', $email)->first();
    }

    public function getTeachers()
    {
        return [];
    }

}
