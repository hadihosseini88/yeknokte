<?php

namespace Hadihosseini88\Discount\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Course\Models\Course;
use Hadihosseini88\Course\Repositories\CourseRepo;

class DiscountController extends Controller
{
    public function index(CourseRepo $courseRepo)
    {
        $courses = $courseRepo->getAll(Course::CONFIRMATION_STATUS_ACCEPTED);
        return view('Discount::index', compact('courses'));
    }
}
