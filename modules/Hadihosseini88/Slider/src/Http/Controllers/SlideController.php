<?php

namespace Hadihosseini88\Slider\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Common\Responses\AjaxResponses;
use Hadihosseini88\Media\Services\MediaFileService;
use Hadihosseini88\Slider\Http\Requests\SlideRequest;
use Hadihosseini88\Slider\Models\Slide;
use Hadihosseini88\Slider\Repositories\SlideRepo;

class SlideController extends Controller
{
    public function index(SlideRepo $repo)
    {
        $this->authorize('manage', Slide::class);
        $slides = $repo->all();
        return view('Slider::index',compact('slides'));
    }

    public function create()
    {
        $this->authorize('manage', Slide::class);
        return view('Slider::create');
    }

    public function store(SlideRequest $request, SlideRepo $repo)
    {
        $this->authorize('manage', Slide::class);
        $request->request->add(['media_id' => MediaFileService::publicUpload($request->file('image'))->id]);
        $repo->store($request);
        return redirect()->route('slides.index');
    }

    public function edit($slideId , SlideRepo $repo)
    {
        $slide= $repo->findById($slideId);
        $this->authorize('manage', Slide::class);
        return view('Slider::edit', compact('slide'));

    }

    public function update(Slide $slide, SlideRepo $repo, SlideRequest $request)
    {
        $this->authorize('manage', Slide::class);
        if ($request->hasFile('image')) {
            $request->request->add(['media_id' => MediaFileService::publicUpload($request->file('image'))->id]);
            if ($slide->media)
                $slide->media->delete();
        } else {
            $request->request->add(['media_id' => $slide->media_id]);
        }
        $repo->update($slide->id,$request);
        return redirect()->route('slides.index');
    }

    public function destroy(Slide $slide)
    {
        $this->authorize('manage', Slide::class);
        if ($slide->media){
            $slide->media->delete();
        }
        $slide->delete();
        return AjaxResponses::SuccessResponse();

    }
}
