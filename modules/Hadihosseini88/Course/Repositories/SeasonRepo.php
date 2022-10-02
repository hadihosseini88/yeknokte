<?php

namespace Hadihosseini88\Course\Repositories;

use Hadihosseini88\Course\Models\Course;
use Hadihosseini88\Course\Models\Season;
use Illuminate\Support\Str;

class SeasonRepo
{
    public function store($id, $values)
    {
        $number = $values->number;
        $courseRepo = new CourseRepo();
        if (is_null($values->number)) {
            $number = $courseRepo->findByid($id)->seasons()->orderBy('number', 'desc')->firstOrNew([])->number ?: 0;
            $number++;
        }
        return Season::create([
            'course_id'=> $id,
            'user_id'=> auth()->id(),
            'title' => $values->title,
            'number' => $number,

            'confirmation_status' => Season::CONFIRMATION_STATUS_PENDING,

        ]);
    }

    public function paginate()
    {
        return Course::paginate();
    }

    public function delete($id)
    {
        Course::where('id', $id)->delete();
    }

    public function findByid($id)
    {
        return Course::findOrFail($id);
    }

    public function update($id, $values)
    {
        return Course::where('id', $id)->update([
            'teacher_id' => $values->teacher_id,
            'category_id' => $values->category_id,
            'banner_id' => $values->banner_id,
            'title' => $values->title,
            'slug' => Str::slug($values->slug),
            'priority' => $values->priority,
            'price' => $values->price,
            'percent' => $values->percent,
            'type' => $values->type,
            'status' => $values->status,
            'body' => $values->body,
        ]);
    }

    public function updateConfirmationStatus($id, string $status)
    {
        return Course::where('id', $id)->update(['confirmation_status' => $status]);
    }

    public function updateStatus($id, string $status)
    {
        return Course::where('id', $id)->update(['status' => $status]);
    }
}
