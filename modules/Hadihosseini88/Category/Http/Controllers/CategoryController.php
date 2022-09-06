<?php

namespace Hadihosseini88\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Category\Http\Requests\CategoryRequest;
use Hadihosseini88\Category\Repositories\CategoryRepo;
use Hadihosseini88\Category\Responses\AjaxResponses;


class CategoryController extends Controller
{
    public $repo;

    public function __construct(CategoryRepo $categoryRepo)
    {
        $this->repo = $categoryRepo;
    }

    public function index()
    {
        $categories = $this->repo->all();
        return view('Categories::index', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        // todo category Repository

        $categories = $this->repo->store($request);
        return back();

    }

    public function edit($categoryId)
    {
        // todo category Repository
        $category  = $this->repo->findById($categoryId);
        $categories = $this->repo->allExceptById($categoryId);
        return view('Categories::edit', compact('category', 'categories'));
    }

    public function update($categoryId, CategoryRequest $request)
    {
        $this->repo->update($categoryId, $request);
        return back();

    }

    public function destroy($categoryId)
    {
        $this->repo->delete($categoryId);
        return AjaxResponses::SuccessResponse();

    }
}
