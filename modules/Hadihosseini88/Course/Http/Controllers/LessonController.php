<?php

namespace Hadihosseini88\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Course\Http\Requests\LessonRequest;
use Hadihosseini88\Course\Repositories\CourseRepo;
use Hadihosseini88\Course\Repositories\LessonRepo;
use Hadihosseini88\Course\Repositories\SeasonRepo;
use Hadihosseini88\Media\Services\MediaFileService;

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
        $request->request->add(['media_id' => MediaFileService::upload($request->file('lesson_file'))->id]);
        $this->lessonRepo->store($course,$request);

        newFeedback();

        return redirect(route('courses.details', $course));
    }

}
