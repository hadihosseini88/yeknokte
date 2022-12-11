<?php

namespace Hadihosseini88\RolePermissions\Policies;

use Hadihosseini88\RolePermissions\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index($user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_ROLE_PERMISSIONS)) return true;
    }

    public function create($user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_ROLE_PERMISSIONS)) return true;
    }

    public function edit($user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_ROLE_PERMISSIONS)) return true;
    }

    public function delete($user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_ROLE_PERMISSIONS)) return true;
    }


}
