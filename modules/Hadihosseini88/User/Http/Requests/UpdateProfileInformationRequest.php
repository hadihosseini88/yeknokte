<?php

namespace Hadihosseini88\User\Http\Requests;

use Hadihosseini88\RolePermissions\Models\Permission;
use Hadihosseini88\RolePermissions\Models\Role;
use Hadihosseini88\User\Rules\ValidPassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileInformationRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check()== true;

    }

    public function rules()
    {
        $rules =[
            'name' => 'required|min:3|max:190',
            'email' => 'required|email|min:3|max:190|unique:users,email,' . auth()->id(),
            'username' => 'nullable|min:3|max:190|unique:users,username,' . auth()->id(),
            'mobile' => 'nullable|unique:users,mobile,' . auth()->id(),
            'password' => ['nullable', new ValidPassword()]
        ];
        if (auth()->user()->hasPermissionTo(Permission::PERMISSION_TEACH)){
            $rules += [

                'card_number' => 'required|string|size:16',
                'shaba' => 'required|string|size:24',
                'headline' => 'required|min:3|max:60',
                'bio' => 'required',
            ];

           $rules['username'] = 'required|min:3|max:190|unique:users,username,' . auth()->id();
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'name' =>'نام و نام خانوادگی',
            'email' => 'ایمیل',
            'username' => 'نام کاربری',
            'mobile' => 'موبایل',
            'password' => 'رمز عبور جدید',
            'card_number' =>'شماره کارت',
            'shaba' => 'شماره شبا',
            'headline' => 'عنوان',
            'bio' => 'بیوگرافی',

        ];
    }
}
