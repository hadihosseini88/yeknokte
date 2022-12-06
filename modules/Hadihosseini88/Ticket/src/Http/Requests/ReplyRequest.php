<?php

namespace Hadihosseini88\Ticket\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplyRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        return [
            'body' => 'required',
            'attachment' => 'nullable|file|mimes:avi,mkv,mp4,zip,rar|max:102400',
        ];
    }

    public function attributes()
    {
        return [
            'attachment' => 'فایل پیوست',
            'body' => 'متن تیکت'
        ];
    }
}
