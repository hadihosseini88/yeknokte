<?php

namespace Hadihosseini88\Ticket\Policies;

use Hadihosseini88\RolePermissions\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
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

    public function show($user, $ticket)
    {
        if (($user->id == $ticket->user_id) || ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_TICKETS))) return true;
    }

    public function delete($user, $ticket)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_TICKETS)) return true;
    }
}
