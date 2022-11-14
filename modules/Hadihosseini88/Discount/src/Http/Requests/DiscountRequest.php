<?php

namespace Hadihosseini88\Discount\Http\Requests;

use App\Rules\ValidJalaliDate;
use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'nullable|unique:discounts,code|max:50',
            'percent'=> 'required|numeric|min:1|max:100',
            'usage_limitation' => 'nullable|numeric|min:1|max:1000000000',
            'expire_at' => ['nullable',new ValidJalaliDate()],
            'courses' => 'nullable|array',
        ];
    }
}
