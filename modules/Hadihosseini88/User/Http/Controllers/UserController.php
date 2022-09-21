<?php

namespace Hadihosseini88\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\RolePermissions\Repositories\RoleRepo;
use Hadihosseini88\User\Http\Requests\AddRoleRequest;
use Hadihosseini88\User\Models\User;
use Hadihosseini88\User\Repositories\UserRepo;

class UserController extends Controller
{
    private $userRepo;

    public function __construct(UserRepo $userRepo)
    {

        $this->userRepo = $userRepo;
    }

    public function index(RoleRepo $roleRepo)
    {
        $this->authorize('index',User::class);
        $users = $this->userRepo->paginate();
        $roles = $roleRepo->all();
        return view('User::Admin.index', compact('users', 'roles'));
    }

    public function addRole(AddRoleRequest $reqeust, User $user)
    {

        $this->authorize('addRole',User::class);
        $user->assignRole($reqeust->role);
        return back();

    }
}
