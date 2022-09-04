<?php
namespace Hadihosseini88\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use Hadihosseini88\Category\Http\Requests\CategoryRequest;
use Hadihosseini88\Category\Models\Category;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index()
    {
        // todo category Repository
        $categories = Category::all();
        return view('Categories::index',compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        // todo category Repository
        Category::create([
            'title'=>$request->title,
            'slug'=>$request->slug,
            'parent_id'=>$request->parent_id,
        ]);

        return back();

    }

    public function edit(Category $category)
    {
        // todo category Repository
        $categories = Category::where('id','!=',$category->id)->get();
        return view('Categories::edit', compact('category','categories'));
    }

    public function update(Category $category,CategoryRequest $request)
    {
        // todo category Repository
        $category->update([
            'title'=>$request->title,
            'slug'=>$request->slug,
            'parent_id'=>$request->parent_id,
        ]);

        return back();
    }

    public function destroy(Category $category)
    {
//        $category->delete();
          return response()->json(['message'=>'عملیات با موفقیت انجام شد.'],Response::HTTP_OK);

    }
}
