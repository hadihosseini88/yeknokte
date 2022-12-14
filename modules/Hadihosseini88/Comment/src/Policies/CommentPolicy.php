<?php

namespace Hadihosseini88\Comment\Policies;

use Hadihosseini88\RolePermissions\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function manage($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COMMENTS)) return true;
        return null;
    }

    public function index($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_TEACH) ||
            $user->hasPermissionTo(Permission::PERMISSION_MANAGE_COMMENTS)) return true;
    }

    public function view($user, $comment)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COMMENTS) ||
            $user->id == $comment->commentable->teacher_id) return true;
        return null;
    }

    public function change_status($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COMMENTS)) return true;
        return null;
    }

}
