<?php

namespace Hadihosseini88\User\Http\Requests;

use Hadihosseini88\User\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:190',
            'email' => 'required|email|min:3|max:190|unique:users,email,' . request()->route('user'),
            'username' => 'nullable|min:3|max:190|unique:users,username,' . request()->route('user'),
            'mobile' => 'nullable|unique:users,mobile,' . request()->route('user'),
            'status' => ['required', Rule::in(User::$statuses)],
            'image' => 'nullable|mimes:jpg,png,jpeg',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام',
            'email' => 'ایمیل',
            'username' => 'نام کاربری',
            'mobile' => 'موبایل',
            'status' => 'وضعیت',
            'image' => 'عکس پروفایل',
        ];
    }
}
