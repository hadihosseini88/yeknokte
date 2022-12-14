<?php

namespace Hadihosseini88\Front\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Course\Repositories\CourseRepo;
use Hadihosseini88\Course\Repositories\LessonRepo;
use Hadihosseini88\RolePermissions\Models\Permission;
use Hadihosseini88\User\Models\User;
use Illuminate\Support\Str;

class FrontController extends Controller
{
    public function index()
    {
        return view('Front::index');
    }

    public function singleCourse($slug, CourseRepo $courseRepo, LessonRepo $lessonRepo)
    {
        $courseId = $this->extractId($slug,'c');
        $course = $courseRepo->findByid($courseId);
        $lessons = $lessonRepo->getAcceptedLessons($courseId);
        if (request()->lesson) {

            $lesson = $lessonRepo->getLesson($courseId,$this->extractId(request()->lesson, 'l'));
        } else {
            $lesson = $lessonRepo->getFirstLesson($courseId);
        }
        return view('Front::singleCourse', compact('course', 'lessons','lesson'));
    }


    public function extractId($slug, $key)
    {
        return Str::before(Str::after($slug, $key.'-'), '-');
    }

    public function singleTutor($username)
    {
        $tutor = User::permission(Permission::PERMISSION_TEACH)->where('username', $username)->first();
        if (is_null($tutor)) $tutor='ok';
        return view('Front::tutor', compact('tutor'));
    }
}
