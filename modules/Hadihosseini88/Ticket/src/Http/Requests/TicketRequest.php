<?php

namespace Hadihosseini88\Ticket\Http\Requests;

use Hadihosseini88\Course\Models\Course;
use Hadihosseini88\Course\Rules\ValidSeason;
use Hadihosseini88\Course\Rules\ValidTeacher;
use Hadihosseini88\Media\Services\MediaFileService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class TicketRequest extends FormRequest
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
            'body'=> 'required',
            'attachment' => 'nullable|file|mimes:avi,mp4,mkv,zip,rar,docx,pdf,jpg,png|max:10240',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'عنوان تیکت',
            'attachment' => 'فایل پیوست',
            'body' => 'متن تیکت'
        ];
    }
}
