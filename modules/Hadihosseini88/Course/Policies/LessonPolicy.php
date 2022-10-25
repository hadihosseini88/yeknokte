<?php

namespace Hadihosseini88\Course\Policies;

use Hadihosseini88\Course\Repositories\CourseRepo;
use Hadihosseini88\RolePermissions\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class LessonPolicy
{
    use HandlesAuthorization;

    public function edit($user, $lesson)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
            ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && ($user->id == $lesson->course->teacher_id))
        ) {
            return true;
        }
    }

    public function delete($user, $lesson)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
            ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $user->id == $lesson->course->teacher_id)
        ) {
            return true;
        }
    }

    public function download($user, $lesson)
    {
        if (($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) ||
            ($user->id == $lesson->course->teacher_id) ||
            $lesson->course->hasStudent($user->id) ||
            $lesson->is_free) {
            return true;
        }
        return false;
    }

}
