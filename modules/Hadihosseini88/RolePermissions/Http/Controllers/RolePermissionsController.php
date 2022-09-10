<?php

namespace Hadihosseini88\RolePermissions\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Category\Responses\AjaxResponses;
use Hadihosseini88\RolePermissions\Http\Requests\RoleRequest;
use Hadihosseini88\RolePermissions\Http\Requests\RoleUpdateRequest;
use Hadihosseini88\RolePermissions\Repositories\PermissionRepo;
use Hadihosseini88\RolePermissions\Repositories\RoleRepo;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionsController extends Controller
{
    private $roleRepo;
    private $permissionRepo;

    public function __construct(RoleRepo $roleRepo, PermissionRepo $permissionRepo)
    {
        $this->roleRepo = $roleRepo;
        $this->permissionRepo = $permissionRepo;
    }

    public function index()
    {
        $roles = $this->roleRepo->all();
        $permissions = $this->permissionRepo->all();
        return view('RolePermissions::index', compact('roles', 'permissions'));
    }

    public function store(RoleRequest $request)
    {
        return $this->roleRepo->create($request);
    }

    public function edit($roleId)
    {
        $role = $this->roleRepo->findById($roleId);
        $permissions = $this->permissionRepo->all();
        return view("RolePermissions::edit", compact('role', 'permissions'));
    }

    public function update(RoleUpdateRequest $request,$id)
    {
        $this->roleRepo->update($request,$id);
        return redirect(route('role-permissions.index'));
    }

    public function destroy($roleId)
    {
        $this->roleRepo->delete($roleId);
        return AjaxResponses::SuccessResponse();
    }

}
