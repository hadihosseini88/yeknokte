<?php

namespace Hadihosseini88\Slider\Repositories;

use Hadihosseini88\Slider\Models\Slide;

class SlideRepo
{
    public function all()
    {
        return Slide::query()->orderBy('priority')->latest()->get();
    }

    public function findById($id)
    {
        return Slide::query()->findOrFail($id);
    }

    public function store($values)
    {
        return Slide::query()->create([
            'user_id' => auth()->id(),
            'title' => $values->title,
            'priority' => $values->priority,
            'link' => $values->link,
            'media_id' => $values->media_id,
            'status'=>$values->status,
        ]);
    }

    public function update($id,$values)
    {
        return Slide::query()->where('id', $id)->update([
            'title' => $values->title,
            'priority' => $values->priority,
            'link' => $values->link,
            'media_id' => $values->media_id,
            'status'=>$values->status,
        ]);
    }

    public function delete($id)
    {
        Slide::query()->where('id', $id)->delete();
    }
}
