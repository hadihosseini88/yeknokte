<?php

namespace Hadihosseini88\Comment\Http\Requests;

use Hadihosseini88\Comment\Rules\CommentableRule;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'body' => 'required',
            'commentable_id' => 'required',
            'commentable_type' => ['required', new CommentableRule()],
        ];
    }
}
