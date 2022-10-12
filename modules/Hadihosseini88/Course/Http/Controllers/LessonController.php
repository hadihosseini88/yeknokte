<?php

namespace Hadihosseini88\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Common\Responses\AjaxResponses;
use Hadihosseini88\Course\Http\Requests\LessonRequest;
use Hadihosseini88\Course\Models\Lesson;
use Hadihosseini88\Course\Repositories\CourseRepo;
use Hadihosseini88\Course\Repositories\LessonRepo;
use Hadihosseini88\Course\Repositories\SeasonRepo;
use Hadihosseini88\Media\Services\MediaFileService;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    private $lessonRepo;

    public function __construct(LessonRepo $lessonRepo)
    {

        $this->lessonRepo = $lessonRepo;
    }

    public function create($course, SeasonRepo $seasonRepo, CourseRepo $courseRepo)
    {
        $seasons = $seasonRepo->getCourseSeasons($course);
        $course = $courseRepo->findByid($course);
        return view('Courses::lessons.create', compact('seasons', 'course'));
    }

    public function store($course, LessonRequest $request)
    {
        $request->request->add(['media_id' => MediaFileService::privateUpload($request->file('lesson_file'))->id]);
        $this->lessonRepo->store($course, $request);

        newFeedback();

        return redirect(route('courses.details', $course));
    }

    public function edit($courseId, $lessonId, SeasonRepo $seasonRepo, CourseRepo $courseRepo)
    {
        $seasons = $seasonRepo->getCourseSeasons($courseId);
        $lesson = $this->lessonRepo->findByid($lessonId);
        $course = $courseRepo->findByid($courseId);
        return view('Courses::lessons.edit', compact('lesson', 'seasons', 'course'));
    }

    public function update()
    {
       dd('ok');
    }

    public function accept($id)
    {
        $this->lessonRepo->updateConfirmationStatus($id, Lesson::CONFIRMATION_STATUS_ACCEPTED);
        return AjaxResponses::SuccessResponse();
    }

    public function reject($id)
    {
        $this->lessonRepo->updateConfirmationStatus($id, Lesson::CONFIRMATION_STATUS_REJECTED);
        return AjaxResponses::SuccessResponse();
    }

    public function lock($id, LessonRepo $seasonRepo)
    {
        if ($seasonRepo->updateStatus($id, Lesson::STATUS_LOCKED)) {
            return AjaxResponses::SuccessResponse();
        }
        return AjaxResponses::FailedResponse();
    }

    public function unlock($id, LessonRepo $seasonRepo)
    {
        if ($seasonRepo->updateStatus($id, Lesson::STATUS_OPENED)) {
            return AjaxResponses::SuccessResponse();
        }
        return AjaxResponses::FailedResponse();
    }

    public function destroy($courseId, $lessonId)
    {
        $lesson = $this->lessonRepo->findByid($lessonId);
        if ($lesson->media)
            $lesson->media->delete();
        $lesson->delete();

        return AjaxResponses::SuccessResponse();
    }

    public function destroyMultiple(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $lesson = $this->lessonRepo->findByid($id);
            if ($lesson->media)
                $lesson->media->delete();
            $lesson->delete();
        }
        newFeedback();
        return back();
    }

}
