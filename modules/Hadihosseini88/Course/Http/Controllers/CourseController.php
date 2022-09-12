<?php

namespace Hadihosseini88\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Category\Repositories\CategoryRepo;
use Hadihosseini88\Course\Http\Requests\CourseRequest;
use Hadihosseini88\User\Repositories\UserRepo;

class CourseController extends Controller
{
    public function index()
    {

    }

    public function create(UserRepo $userRepo, CategoryRepo $categoryRepo)
    {
        $teachers =$userRepo->getTeachers();
        $categories = $categoryRepo->all();
        return view('Courses::create',compact('teachers','categories'));
    }

    public function store(CourseRequest $request)
    {
        dd($request,'eyval');

    }
}
