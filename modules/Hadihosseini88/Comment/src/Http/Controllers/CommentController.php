<?php

namespace Hadihosseini88\Comment\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Comment\Http\Requests\CommentRequest;
use Hadihosseini88\Comment\Repositories\CommentRepo;


class CommentController extends Controller
{
    public function store(CommentRequest $request, CommentRepo $repo)
    {
        $commentable = $request->commentable_type::findOrFail($request->commentable_id);
        $repo->store($request->all());
        newFeedback('عملیات موفقیت آمیز','دیدگاه شما با موفقیت ثبت گردید.');
        return redirect($commentable->path());
    }

}
