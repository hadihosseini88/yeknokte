<?php

namespace Hadihosseini88\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Course\Repositories\CourseRepo;
use Hadihosseini88\Course\Repositories\SeasonRepo;

class LessonController extends Controller
{
    public function create($course,SeasonRepo $seasonRepo)
    {
        $seasons = $seasonRepo->getCourseSeasons($course);
        return view('Courses::lessons.create', compact('seasons','course'));
    }

}
