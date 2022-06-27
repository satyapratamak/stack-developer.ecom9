<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;

class IndexController extends Controller
{
    public function index()
    {

        $sections = Section::sections();

        // echo "<pre>";
        // print_r($sections);
        // die;
        return view('front.index')->with(compact('sections'));
    }
}
