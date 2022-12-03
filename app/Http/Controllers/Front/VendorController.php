<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Models\Section;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    //
    public function loginRegister()
    {
        $sections = Section::sections();
        return view('front.vendors.login_register')->with(compact('sections'));
    }
}
