<?php
namespace Hadihosseini88\Category\Http\Controllers;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        return view('Categories::index');
    }
}
