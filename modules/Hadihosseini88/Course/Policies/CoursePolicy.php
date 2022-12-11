<?php

namespace Hadihosseini88\Course\Policies;

use Hadihosseini88\RolePermissions\Models\Permission;
use Hadihosseini88\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
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

    public function manage(User $user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;
    }

    public function index(User $user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
            $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES)) return true;
    }

    public function create(User $user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
            $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES)) return true;

    }

    public function edit(User $user, $course)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $course->teacher->id == $user->id) return true;
    }


    public function delete(User $user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;
    }

    public function change_confirmation_status(User $user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;
    }

    public function details($user, $course)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) {
            return true;
        }
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $course->teacher_id == $user->id) {
            return true;
        }
    }

    public function createLesson($user, $course)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
            ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $course->teacher_id == $user->id))
            return true;
    }

    public function createSeason($user, $course)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) {
            return true;
        }
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $course->teacher_id == $user->id) {
            return true;
        }
    }

    public function download($user, $course)
    {
        if (($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) || ($user->id == $course->teacher_id) || $course->hasStudent($user->id)) {
            return true;
        }
        return false;
    }

}
