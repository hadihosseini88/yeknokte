<?php

namespace Hadihosseini88\Payment\Http\Requests;

use Hadihosseini88\Payment\Models\Settlement;
use Illuminate\Foundation\Http\FormRequest;

class SettlementRequest extends FormRequest
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
        $min = 10000;
        if (request()->getMethod() == 'PATCH') {
            return [
                'from.*' => 'required_if:status,' . Settlement::STATUS_SETTLED,
                'to.*' => 'required_if:status,' . Settlement::STATUS_SETTLED,
                'amount' => "required|numeric|min:{$min}",
            ];
        }
        return [
            'name' => 'required',
            'cart' => 'required|numeric',
            'amount' => "required|numeric|min:{$min}|max:" . auth()->user()->balance,
        ];

    }

    public function attributes()
    {
        return [
            'cart' => 'شماره کارت',
            'amount' => 'مبلغ تسویه حساب',
            'name' => 'نام دارنده کارت',
        ];
    }
}
