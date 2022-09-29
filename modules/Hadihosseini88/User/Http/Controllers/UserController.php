<?php

namespace Hadihosseini88\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Common\Responses\AjaxResponses;
use Hadihosseini88\Media\Services\MediaFileService;
use Hadihosseini88\RolePermissions\Repositories\RoleRepo;
use Hadihosseini88\User\Http\Requests\AddRoleRequest;
use Hadihosseini88\User\Http\Requests\UpdateUserRequest;
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
        $this->authorize('index', User::class);
        $users = $this->userRepo->paginate();
        $roles = $roleRepo->all();
        return view('User::Admin.index', compact('users', 'roles'));
    }

    public function edit($userId, RoleRepo $roleRepo)
    {
        $this->authorize('edit', User::class);
        $user = $this->userRepo->findById($userId);
        $roles= $roleRepo->all();
        return view("User::Admin.edit", compact('user','roles'));

    }

    public function update(UpdateUserRequest $request, $userId)
    {
        $this->authorize('edit', User::class);

        $user = $this->userRepo->findById($userId);

        if ($request->hasFile('image')) {
            $request->request->add(['image_id' => MediaFileService::upload($request->file('image'))->id]);
            if ($user->banner)
                $user->banner->delete();
        } else {
            $request->request->add(['image_id' => $user->image_id]);
        }

        $this->userRepo->update($userId, $request);
        newFeedback();
        return redirect()->back();
    }

    public function destroy($userId)
    {
        $user = $this->userRepo->findById($userId);
        $user->delete();
        return AjaxResponses::SuccessResponse();
    }

    public function manualVerify($userId)
    {
        $this->authorize('manualVerify', User::class);
        $user = $this->userRepo->findById($userId);
        $user->markEmailAsVerified();

        return AjaxResponses::SuccessResponse();
    }

    public function addRole(AddRoleRequest $reqeust, User $user)
    {

        $this->authorize('addRole', User::class);
        $user->assignRole($reqeust->role);
        newFeedback('موفقیت آمیز', 'به کاربر ' . $user->name . ' نقش کاربری ' . __($reqeust->role) . ' داده شد.', 'success');
        return back();
    }

    public function removeRole($userId, $role)
    {
        $this->authorize('removeRole', User::class);
        $user = $this->userRepo->findById($userId);
        $user->removeRole($role);

        return AjaxResponses::SuccessResponse();
    }
}
