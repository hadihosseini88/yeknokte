<?php

namespace Hadihosseini88\Course\Http\Requests;

use Hadihosseini88\Course\Models\Course;
use Hadihosseini88\Course\Rules\ValidTeacher;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() == true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:3|max:190',
            'slug' => 'required|min:3|max:190|unique:courses,slug',
            'priority' => 'nullable|numeric',
            'price' => 'required|numeric|min:0|max:10000000',
            'percent' => 'required|numeric|min:0|max:100',
            'teacher_id' => ['required', 'exists:users,id', new ValidTeacher()],
            'type' => ['required', Rule::in(Course::$types)],
            'status' => ['required', Rule::in(Course::$statuses)],
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|mimes:jpg,png,jpeg',
        ];
    }

    public function attributes()
    {
        return [
            'title' =>'عنوان دوره',
            'slug' =>'عنوان انگلیسی',
            'priority' =>'ردیف دوره',
            'price' =>'قیمت',
            'percent' =>'درصد دوره',
            'teacher_id' =>'مدرس',
            'type' =>'نوع',
            'status' =>'وضعیت',
            'category_id' =>'دسته بندی',
            'image' =>'بنر دوره',
            'body' => 'توضیحات'
        ];
    }

    public function messages()
    {
        return [
//            "price.min" => trans("Courses::validation.price_min"),
//            "price.max" => trans("Courses::validation.price_max"),
//            "price.required" => trans("Courses::validation.price_required")
        ];
    }
}
