<?php

namespace Hadihosseini88\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Category\Repositories\CategoryRepo;
use Hadihosseini88\Common\Responses\AjaxResponses;
use Hadihosseini88\Course\Http\Requests\CourseRequest;
use Hadihosseini88\Course\Models\Course;
use Hadihosseini88\Course\Repositories\CourseRepo;
use Hadihosseini88\Media\Services\MediaFileService;
use Hadihosseini88\User\Repositories\UserRepo;

class CourseController extends Controller
{
    public function index(CourseRepo $courseRepo)
    {
        $this->authorize('manage',Course::class);
        $courses = $courseRepo->paginate();
        return view('Courses::index', compact('courses'));
    }

    public function create(UserRepo $userRepo, CategoryRepo $categoryRepo)
    {
        $this->authorize('create',Course::class);
        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();
        return view('Courses::create', compact('teachers', 'categories'));
    }

    public function store(CourseRequest $request, CourseRepo $courseRepo)
    {
        $request->request->add(['banner_id' => MediaFileService::upload($request->file('image'))->id]);
        $courseRepo->store($request);
        return redirect()->route('courses.index');
    }

    public function edit($id, CourseRepo $courseRepo, UserRepo $userRepo, CategoryRepo $categoryRepo)
    {
        $course = $courseRepo->findByid($id);
        $this->authorize('edit',$course);
        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();

        return view('Courses::edit', compact('course', 'teachers', 'categories'));
    }

    public function update($id, CourseRequest $request, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findByid($id);
        $this->authorize('edit',$course);
        if ($request->hasFile('image')) {
            $request->request->add(['banner_id' => MediaFileService::upload($request->file('image'))->id]);
            if ($course->banner)
                $course->banner->delete();
        } else {
            $request->request->add(['banner_id'=>$course->banner_id]);
        }
        $courseRepo->update($id, $request);

        return redirect(route('courses.index'));
    }

    public function details($id, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findByid($id);
        $this->authorize('details',$course);
        return view('Courses::details', compact('course'));
    }

    public function destroy($id, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findByid($id);
        $this->authorize('delete',$course);
        if ($course->banner) {
            $course->banner->delete();
        }

        $course->delete();
        return AjaxResponses::SuccessResponse();

    }

    public function accept($id, CourseRepo $courseRepo)
    {
        $this->authorize('change_confirmation_status',Course::class);
        if ($courseRepo->updateConfirmationStatus($id,Course::CONFIRMATION_STATUS_ACCEPTED)){
            return AjaxResponses::SuccessResponse();
        }
        return AjaxResponses::FailedResponse();
    }
    public function reject($id, CourseRepo $courseRepo) {
        $this->authorize('change_confirmation_status',Course::class);
        if ($courseRepo->updateConfirmationStatus($id,Course::CONFIRMATION_STATUS_REJECTED)){
            return AjaxResponses::SuccessResponse();
        }
        return AjaxResponses::FailedResponse();
    }

    public function lock($id, CourseRepo $courseRepo) {
        $this->authorize('change_confirmation_status',Course::class);
        if ($courseRepo->updateStatus($id,Course::STATUS_LOCKED)){
            return AjaxResponses::SuccessResponse();
        }
        return AjaxResponses::FailedResponse();
    }

}
