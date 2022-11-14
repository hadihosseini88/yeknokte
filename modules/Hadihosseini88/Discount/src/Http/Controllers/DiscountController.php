<?php

namespace Hadihosseini88\Discount\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Course\Models\Course;
use Hadihosseini88\Course\Repositories\CourseRepo;
use Hadihosseini88\Discount\Http\Requests\DiscountRequest;
use Hadihosseini88\Discount\Repositories\DiscountRepo;

class DiscountController extends Controller
{
    public function index(CourseRepo $courseRepo, DiscountRepo $discountRepo)
    {
        $discounts = $discountRepo->paginateAll();
        $courses = $courseRepo->getAll(Course::CONFIRMATION_STATUS_ACCEPTED);
        return view('Discount::index', compact('courses','discounts'));
    }

    public function store(DiscountRequest $request, DiscountRepo $repo)
    {
        $repo->store($request->all());

        newFeedback();

        return back();
    }

}
