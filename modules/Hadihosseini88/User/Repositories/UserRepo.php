<?php

namespace Hadihosseini88\User\Repositories;

use Hadihosseini88\RolePermissions\Models\Permission;
use Hadihosseini88\User\Models\User;

class UserRepo
{
    public function findByEmail($email)
    {
        return User::query()->where('email', $email)->first();
    }

    public function getTeachers()
    {
        return User::permission(Permission::PERMISSION_TEACH)->get();
    }

    public function findById($id)
    {
        return User::findOrFail($id);
    }

    public function paginate()
    {
        return User::paginate();
    }

    public function update($userId, $values)
    {
        $update = [
            'name' => $values->name,
            'email' => $values->email,
            'username' => $values->username,
            'mobile' => $values->mobile,
            'headline' => $values->headline,
            'status' => $values->status,
            'bio' => $values->bio,
            'image_id' => $values->image_id,
        ];

        if (!is_null($values->password)) {
            $update['password'] = bcrypt($values->password);
        }

        $user = User::find($userId);
        $user->syncRoles([]);
        $user->assignRole($values['role']);

        return User::where('id', $userId)->update($update);
    }
}
