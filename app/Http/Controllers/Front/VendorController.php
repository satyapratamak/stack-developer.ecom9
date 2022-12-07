<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    //
    public function loginRegister()
    {
        $sections = Section::sections();
        return view('front.vendors.login_register')->with(compact('sections'));
    }

    //
    public function vendorRegister(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $rules = [
                "name" => "required",
                "email" => "required|email|unique:admins|unique:vendors",
                "mobile" => "required|digits:10|numeric|unique:admins|unique:vendors",
                "accept" => "required",
            ];

            $customMessages = [
                "name.required" => "Name is required",
                "email.required" => "Email is required",
                "email.unique" => "Email already exists",
                "mobile.required" => "Mobile is required",
                "mobile.digits:10" => "Mobile number have more than 9 digits",
                "mobile.numeric" => "Mobile number must fulfilled with number",
                "accept.required" => "Please accept the Term and Conditions"

            ];

            $validator = Validator::make($data, $rules, $customMessages);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            }
        }
    }
}
