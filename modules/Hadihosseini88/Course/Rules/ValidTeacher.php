<?php

namespace Hadihosseini88\Course\Rules;

use Hadihosseini88\RolePermissions\Models\Permission;
use Hadihosseini88\User\Repositories\UserRepo;
use Illuminate\Contracts\Validation\Rule;

class ValidTeacher implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = (new UserRepo())->findById($value);
//        $user = resolve(UserRepo::class)->findById($value);
        return ($user->hasAnyPermission([Permission::PERMISSION_TEACH,Permission::PERMISSION_SUPER_ADMIN]));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'کاربر انتخاب شده نقش مدرس ندارد.';
    }
}
