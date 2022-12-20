<?php
namespace Hadihosseini88\Slider\Policies;

use Hadihosseini88\RolePermissions\Models\Permission;
use Hadihosseini88\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SlidePolicy
{
    use HandlesAuthorization;

    public function manage(User $user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_SLIDES)) return true;
    }

}
