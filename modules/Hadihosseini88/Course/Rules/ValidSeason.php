<?php

namespace Hadihosseini88\Course\Rules;

use Hadihosseini88\Course\Repositories\SeasonRepo;
use Hadihosseini88\User\Repositories\UserRepo;
use Illuminate\Contracts\Validation\Rule;

class ValidSeason implements Rule
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
        $season = resolve(SeasonRepo::class)->findByIdAndCourseId($value, request()->route('course'));

        if ($season){
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'سرفصل انتخاب شده معتبر نمی باشد.';
    }
}
