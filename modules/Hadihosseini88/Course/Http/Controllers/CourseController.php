<?php

namespace Hadihosseini88\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\User\Repositories\UserRepo;

class CourseController extends Controller
{
    public function index()
    {

    }

    public function create(UserRepo $userRepo)
    {
        $teachers =$userRepo->getTeachers();
        return view('Courses::create',compact('teachers'));
    }
}
