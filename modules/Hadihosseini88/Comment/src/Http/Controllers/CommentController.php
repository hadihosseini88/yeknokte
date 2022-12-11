<?php

namespace Hadihosseini88\Comment\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Comment\Http\Requests\CommentRequest;
use Hadihosseini88\Comment\Repositories\CommentRepo;
use Hadihosseini88\Common\Responses\AjaxResponses;


class CommentController extends Controller
{
    public function index(CommentRepo $repo)
    {
        $comments = $repo->paginateParents();
        return view('Comments::index', compact('comments'));
    }

    public function store(CommentRequest $request, CommentRepo $repo)
    {
        $commentable = $request->commentable_type::findOrFail($request->commentable_id);
        $repo->store($request->all());
        newFeedback('عملیات موفقیت آمیز', 'دیدگاه شما با موفقیت ثبت گردید.');
        return redirect($commentable->path());
    }

    public function destroy($id, CommentRepo $repo)
    {
        $comment = $repo->findOrFail($id);
        $comment->delete();
        return AjaxResponses::SuccessResponse();
    }

}
