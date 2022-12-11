<?php

namespace Hadihosseini88\Comment\Repositories;

use Hadihosseini88\Comment\Models\Comment;
use Hadihosseini88\RolePermissions\Models\Permission;

class CommentRepo
{
    public function paginate()
    {
        return Comment::query()->latest()->paginate();
    }
    public function store($data)
    {
        return Comment::query()->create([
            'user_id' => auth()->id(),
            'comment_id' => array_key_exists('comment_id', $data) ? $data['comment_id'] : null,
            'body' => $data['body'],
            'commentable_id' => $data['commentable_id'],
            'commentable_type' => $data['commentable_type'],
            'status' => (auth()->user()->can(Permission::PERMISSION_MANAGE_COMMENTS) ||
                        auth()->user()->can(Permission::PERMISSION_TEACH)) ?
                        Comment::STATUS_APPROVED :
                        Comment::STATUS_NEW,
        ]);
    }

    public function findApproved($id)
    {
        return Comment::query()
            ->where('id',$id)
            ->where('status', Comment::STATUS_APPROVED)
            ->first();
    }

    public function findOrFail($id)
    {
        return Comment::query()->findOrFail($id);
    }

    public function paginateParents()
    {
        return Comment::query()->whereNull('comment_id')->withCount('notApprovedComments')->latest()->paginate();
    }

}
