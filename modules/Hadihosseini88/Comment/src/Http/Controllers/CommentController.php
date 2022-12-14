<?php

namespace Hadihosseini88\Comment\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Comment\Http\Requests\CommentRequest;
use Hadihosseini88\Comment\Models\Comment;
use Hadihosseini88\Comment\Repositories\CommentRepo;
use Hadihosseini88\Common\Responses\AjaxResponses;
use Hadihosseini88\Course\Models\Course;
use Hadihosseini88\RolePermissions\Models\Permission;


class CommentController extends Controller
{
    public function index(CommentRepo $repo)
    {
        $this->authorize('index', Comment::class);
        $comments = $repo
            ->searchBody(request('body'))
            ->searchEmail(request('email'))
            ->searchName(request('name'))
            ->searchStatus(request('status'));

        if (!auth()->user()->hasAnyPermission(Permission::PERMISSION_MANAGE_COMMENTS, Permission::PERMISSION_SUPER_ADMIN)) {
            $comments->query->whereHasMorph('commentable',[Course::class], function ($q) {
                return $q->where('teacher_id', auth()->id());
            })->where("status", Comment::STATUS_APPROVED);
        }
        $comments = $comments->paginateParents();


        return view('Comments::index', compact('comments'));
    }

    public function show($id)
    {
        $comment = Comment::query()->where('id', $id)->with('commentable', 'user', 'comments')->firstOrFail();
        $this->authorize('view', $comment);
        return view('Comments::show', compact('comment'));
    }

    public function store(CommentRequest $request, CommentRepo $repo)
    {
        $repo->store($request->all());
        newFeedback('عملیات موفقیت آمیز', 'دیدگاه شما با موفقیت ثبت گردید.');
        return back();
    }


    public function accept($id, CommentRepo $repo)
    {
        $this->authorize('change_status', Comment::class);
        if ($repo->updateStatus($id, Comment::STATUS_APPROVED)) {
            return AjaxResponses::SuccessResponse();
        }
        return AjaxResponses::FailedResponse();
    }

    public function reject($id, CommentRepo $repo)
    {
        $this->authorize('change_status', Comment::class);
        if ($repo->updateStatus($id, Comment::STATUS_REJECTED)) {
            return AjaxResponses::SuccessResponse();
        }
        return AjaxResponses::FailedResponse();
    }

    public function destroy($id, CommentRepo $repo)
    {
        $this->authorize('manage', Comment::class);
        $comment = $repo->findOrFail($id);
        $comment->delete();
        return AjaxResponses::SuccessResponse();
    }
}
