<?php

namespace Hadihosseini88\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Course\Http\Requests\SeasonRequest;
use Hadihosseini88\Course\Repositories\SeasonRepo;

class SeasonController extends Controller
{
    public function store($course,SeasonRequest $request, SeasonRepo $seasonRepo)
    {
        $seasonRepo->store($course, $request);

        newFeedback();

        return back();
    }
}
