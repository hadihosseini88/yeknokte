<?php
namespace Hadihosseini88\Front\Http\Controllers;

use App\Http\Controllers\Controller;

class FrontController extends Controller
{
    public function index()
    {
        return view('Front::index');
    }

}
