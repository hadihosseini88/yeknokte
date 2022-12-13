<?php

namespace Hadihosseini88\Comment\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Comment\Http\Requests\CommentRequest;
use Hadihosseini88\Comment\Models\Comment;
use Hadihosseini88\Comment\Repositories\CommentRepo;
use Hadihosseini88\Common\Responses\AjaxResponses;


class CommentController extends Controller
{
    public function index(CommentRepo $repo)
    {
        $comments = $repo
            ->searchBody(request('body'))
            ->searchEmail(request('email'))
            ->searchName(request('name'))
            ->searchStatus(request('status'))
            ->paginateParents();
        return view('Comments::index', compact('comments'));
    }

    public function show($id)
    {
        $comment = Comment::query()->where('id', $id)->with('commentable', 'user', 'comments')->firstOrFail();
        return view('Comments::show', compact('comment'));
    }

    public function store(CommentRequest $request, CommentRepo $repo)
    {
        $commentable = $request->commentable_type::findOrFail($request->commentable_id);
        $repo->store($request->all());
        newFeedback('عملیات موفقیت آمیز', 'دیدگاه شما با موفقیت ثبت گردید.');
        return back();
    }


    public function accept($id, CommentRepo $repo)
    {
        if ($repo->updateStatus($id, Comment::STATUS_APPROVED)) {
            return AjaxResponses::SuccessResponse();
        }
        return AjaxResponses::FailedResponse();
    }

    public function reject($id, CommentRepo $repo)
    {
        if ($repo->updateStatus($id, Comment::STATUS_REJECTED)) {
            return AjaxResponses::SuccessResponse();
        }
        return AjaxResponses::FailedResponse();
    }

    public function destroy($id, CommentRepo $repo)
    {
        $comment = $repo->findOrFail($id);
        $comment->delete();
        return AjaxResponses::SuccessResponse();
    }
}
