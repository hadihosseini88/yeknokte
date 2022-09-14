<?php

namespace Hadihosseini88\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Category\Repositories\CategoryRepo;
use Hadihosseini88\Course\Http\Requests\CourseRequest;
use Hadihosseini88\Course\Repositories\CourseRepo;
use Hadihosseini88\Media\Services\MediaUploadService;
use Hadihosseini88\User\Repositories\UserRepo;

class CourseController extends Controller
{
    public function index(CourseRepo $courseRepo)
    {
        $courses = $courseRepo->paginate();
        return view('Courses::index',compact('courses'));
    }

    public function create(UserRepo $userRepo, CategoryRepo $categoryRepo)
    {
        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();
        return view('Courses::create', compact('teachers', 'categories'));
    }

    public function store(CourseRequest $request, CourseRepo $courseRepo)
    {
        $request->request->add(['banner_id' => MediaUploadService::upload($request->file('image'))->id]);
        $courseRepo->store($request);
        return redirect()->route('courses.index');
    }
}
