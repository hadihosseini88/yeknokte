<?php

namespace Hadihosseini88\Course\Http\Requests;

use Hadihosseini88\Course\Models\Course;
use Hadihosseini88\Course\Rules\ValidSeason;
use Hadihosseini88\Course\Rules\ValidTeacher;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class LessonRequest extends FormRequest
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
        $rules = [
            'title' => 'required|min:3|max:190',
            'slug' => 'nullable|min:3|max:190',
            'number' => 'nullable|numeric',
            'time' => 'required|numeric|min:0|max:255',
            'season_id' => [ new ValidSeason() ],
            'free' => 'required|boolean',
            'lesson_file' => 'required|file|mimes:avi,mp4,mkv,zip,rar',
        ];
//        if (request()->method == 'PATCH') {
//            $rules['image'] = 'nullable|mimes:jpg,png,jpeg,JPG,PNG,JPEG';
//            $rules['slug'] = 'required|min:3|max:190|unique:courses,slug,' . request()->route('course');
//        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'title' => 'عنوان درس',
            'slug' => 'عنوان انگلیسی درس',
            'number' => 'شماره درس',
            'time' => 'زمان به دقیقه',
            'season_id' => 'شناسه سرفصل',
            'free' => 'نوع دوره',
            'lesson_file' => 'فایل درس',
            'body' => 'توضیحات'
        ];
    }
}
