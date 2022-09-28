<?php

namespace Hadihosseini88\RolePermissions\Models;

class Role extends \Spatie\Permission\Models\Role
{

    const ROLE_SUPER_ADMIN = 'super admin';
    const ROLE_TEACHER = 'teacher';
    const ROLE_STUDENT = 'student';
    static $roles = [
        self::ROLE_TEACHER => [Permission::PERMISSION_TEACH],
        self::ROLE_STUDENT => [],
        self::ROLE_SUPER_ADMIN => [Permission::PERMISSION_SUPER_ADMIN],
    ];
}
