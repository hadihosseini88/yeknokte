<?php

namespace Hadihosseini88\Comment\Rules;

use Hadihosseini88\Comment\Repositories\CommentRepo;
use Illuminate\Contracts\Validation\Rule;

class ApprovedCommentRule implements Rule
{

    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        $commentRepo = new CommentRepo();
        return !is_null($commentRepo->findApproved($value));
    }

    public function message()
    {
        return 'The validation error message.';
    }
}
