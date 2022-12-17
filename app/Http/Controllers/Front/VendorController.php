<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;

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

            // Send confirmation email
            $email = $data['email'];
            $messageData = [
                'email' => $email,
                'name' => $data['name'],
                'code' => base64_encode($email),
            ];

            Mail::send('emails.vendor_confirmation', $messageData, function ($message) use ($email) {
                $message->to($email)->subject('Confirm your Vendor Account');
            });

            DB::commit();



            // Redirect back Vendor with Success Message
            $message = 'Thanks for registering as Vendor. Please check your email to activate your Vendor Account';

            return redirect()->back()->with('success_message', $message);
        }
    }

    public function confirmVendor($email)
    {
        // Decode Vendor Email
        $decodedEmail = base64_decode($email);

        // Check Vendor Mail exists
        $vendorCount = Vendor::where('email', $decodedEmail)->count();

        if ($vendorCount > 0) {
            // Vendor Email exists

            // Check activation of the email
            $vendorDetails =
                Vendor::where('email', $decodedEmail)->first();

            if ($vendorDetails->confrim == "Yes") {
                $message = "Your account is already confirmed..Please login to get new feature of our Apps";
                return redirect('vendor/login-register')->with('error_message', $message);
            } else {
                // Update confirm column in Admins table and Vendor table
                Admin::where('email', $decodedEmail)->update(['confirm' => 'Yes']);
                Vendor::where('email', $decodedEmail)->update(['confirm' => 'Yes']);

                // Send register email
                $messageData = [
                    'email' => $decodedEmail,
                    'name' => $vendorDetails->name,
                    'mobile' => $vendorDetails->mobile,
                ];

                //$email = explode(',', $email);

                Mail::send('emails.vendor_confirmed', $messageData, function ($message) use ($decodedEmail) {
                    $message->to($decodedEmail)->subject('Your Vendor Confired ');
                });

                //Redirect to Vendor Login/Register page with success message
                $message = "Your vendor  email account  is confirmed..You can login and add your
                personal, business and bank details to activate your Vendor Account..";

                return redirect('vendor/login-register')->with('success_message', $message);
            }
        } else {
            abort(404);
        }
    }
}
