<?php

namespace Hadihosseini88\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Common\Responses\AjaxResponses;
use Hadihosseini88\Course\Http\Requests\SeasonRequest;
use Hadihosseini88\Course\Models\Season;
use Hadihosseini88\Course\Repositories\CourseRepo;
use Hadihosseini88\Course\Repositories\SeasonRepo;

class SeasonController extends Controller
{
    private $seasonRepo;

    public function __construct(SeasonRepo $seasonRepo)
    {

        $this->seasonRepo = $seasonRepo;
    }

    public function store($course,SeasonRequest $request, CourseRepo $courseRepo)
    {
        $this->authorize('createSeason', $courseRepo->findByid($course));
        $this->seasonRepo->store($course, $request);
        newFeedback();
        return back();
    }

    public function edit($id)
    {
        $season = $this->seasonRepo->findByid($id);
        $this->authorize('edit', $season);
        return view('Courses::seasons.edit', compact('season'));
    }

    public function update($id, SeasonRequest $request)
    {
        $this->authorize('edit', $this->seasonRepo->findByid($id));
        $this->seasonRepo->update($id, $request);
        newFeedback();
        return back();
    }

    public function destroy($id)
    {
        $season = $this->seasonRepo->findByid($id);
        $this->authorize('delete', $season);
        $season->delete();

//        return AjaxResponses::SuccessResponse();
    }

    public function accept($id, SeasonRepo $seasonRepo)
    {
        $this->authorize('change_confirmation_status',Season::class);
        if ($seasonRepo->updateConfirmationStatus($id,Season::CONFIRMATION_STATUS_ACCEPTED)){
            return AjaxResponses::SuccessResponse();
        }
        return AjaxResponses::FailedResponse();
    }
    public function reject($id, SeasonRepo $seasonRepo) {
        $this->authorize('change_confirmation_status',Season::class);
        if ($seasonRepo->updateConfirmationStatus($id,Season::CONFIRMATION_STATUS_REJECTED)){
            return AjaxResponses::SuccessResponse();
        }
        return AjaxResponses::FailedResponse();
    }

    public function lock($id, SeasonRepo $seasonRepo) {

        $this->authorize('change_confirmation_status',Season::class);
        if ($seasonRepo->updateStatus($id,Season::STATUS_LOCKED)){
            return AjaxResponses::SuccessResponse();
        }
        return AjaxResponses::FailedResponse();
    }

    public function unlock($id, SeasonRepo $seasonRepo) {
        $this->authorize('change_confirmation_status',Season::class);
        if ($seasonRepo->updateStatus($id,Season::STATUS_OPENED)){
            return AjaxResponses::SuccessResponse();
        }
        return AjaxResponses::FailedResponse();
    }

}
