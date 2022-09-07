<?php

namespace Hadihosseini88\RolePermissions\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\RolePermissions\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionsController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('RolePermissions::index', compact('roles','permissions'));
    }

    public function store(RoleRequest $request)
    {

    }

}
