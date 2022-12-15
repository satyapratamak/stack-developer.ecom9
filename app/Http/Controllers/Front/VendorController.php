<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Vendor;
use App\Models\Admin;

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
                "mobile" => "required|min:10|numeric|unique:admins|unique:vendors",
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

            /** CREATE VENDOR ACCOUNT */


            DB::beginTransaction();
            // Insert vendor details to vendors table
            $vendor = new Vendor;
            $vendor->name = $data['name'];
            $vendor->mobile = $data['mobile'];
            $vendor->email = $data['email'];
            $vendor->status = 0;

            // Set Default time to Indonesia
            date_default_timezone_set("Asia/Jakarta");

            $vendor->created_at = date("Y-m-d H:i:s");
            $vendor->updated_at = date("Y-m-d H:i:s");
            $vendor->save();



            // Insert vendor details to admins table
            $vendor_id = DB::getPdo()->lastInsertId();

            $admin = new Admin;
            $admin->name = $data['name'];
            $admin->type = 'vendor';
            $admin->vendor_id = $vendor_id;
            $admin->mobile = $data['mobile'];

            $admin->email = $data['email'];
            $admin->password = bcrypt($data['password']);

            $admin->status = 0;

            $admin->created_at = date("Y-m-d H:i:s");
            $admin->updated_at = date("Y-m-d H:i:s");
            $admin->save();

            DB::commit();

            // Send confirmation email

            // Redirect back Vendor with Success Message
            $message = 'Thanks for registering as Vendor. We will confirm by email once your account is approved';

            return redirect()->back()->with('success_message', $message);
        }
    }
}
