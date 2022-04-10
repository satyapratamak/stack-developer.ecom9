<?php

namespace App\Http\Controllers\Admin;

//use Image;
use App\Models\Admin;
//use Hash;
use App\Models\Vendor;
use Illuminate\Http\Request;

use App\Models\VendorsBankDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use App\Models\VendorsBusinessDetails;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->all();

            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];

            $customMessages = [
                'email.required' => "Email wajib diisi..",
                'email.email' => "Format email tidak sesuai",
                'email.max' => "Email hanya boleh maksimal 255 karakter",
                'password.required' => "Password wajib diisi..",
            ];

            $this->validate($request, $rules, $customMessages);

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => '1'])) {
                return redirect('admin/dashboard');
            } else {
                return redirect()->back()->with('error_message', 'Email atau Password tidak valid!');
            }
        }
        return view('admin.login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }

    public function updateAdminPassword(Request $request)
    {
        // echo "<pre>"; print_r(Auth::guard('admin')->user()); die;

        if ($request->isMethod('post')) {
            $data = $request->all();

            // Check if current password entered by admin is correct
            if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
                //Check if new password is matching with confirm password
                if ($data['new_password'] == $data['confirm_password']) {
                    Admin::where('email', $data['email'])->update(['password' => bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success_message', 'Your password has been updated successfully');
                } else {
                    return redirect()->back()->with('error_message', 'New Password and Confirm Password are not match');
                }
            } else {
                return redirect()->back()->with('error_message', 'Your current password is Incorrect');
            }
        }

        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update_admin_password')->with(compact('adminDetails'));
    }

    public function updateAdminDetails(Request $request)
    {
        //$adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        if ($request->isMethod('post')) {
            $data = $request->all();
            //  echo "<pre>"; print_r($data); die;


            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric|digits_between:8,15',
            ];


            $customMessages = [
                'admin_name.required' => 'Name field is required',
                'admin_name.regex' => 'Valid name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric' => 'Mobile just can be filled with number',
                'admin_mobile.digits_between' => 'Mobile length is from 8 to 15 digits',
            ];

            // Upload Admin Photo
            if ($request->hasFile('admin_image')) {
                $image_temp = $request->file('admin_image');
                if ($image_temp->isValid()) {

                    // Get Image Extension
                    $extension = $image_temp->getClientOriginalExtension();

                    // Generate File Named
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'admin/images/photos/' . $imageName;

                    Image::make($image_temp)->save($imagePath);
                }
            } else if (!empty($data['current_admin_image'])) {
                $imageName = Auth::guard('admin')->user()->image;
            } else {
                $imageName = "";
            }

            $this->validate($request, $rules, $customMessages);
            Admin::where('email', $data['email'])->update(['name' => $data['admin_name'], 'mobile' => $data['admin_mobile'], 'image' => $imageName]);
            return redirect()->back()->with('success_message', 'Admin Details has been updated successfully');
        }

        return view('admin.settings.update_admin_details');
    }

    public function updateVendorDetails($slug, Request $request)
    {
        if ($slug == "personal") {

            if ($request->isMethod('POST')) {

                $data = $request->all();

                //echo "<pre>"; print_r($data); die;


                $rules = [

                    'name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'address' => 'required|max:255',
                    'city' => 'required|max:255',
                    'state' => 'required|max:255',
                    'country' => 'required|max:255',
                    'pincode' => 'required|max:255',
                    'admin_mobile' => 'required|numeric|digits_between:8,15',

                ];


                $customMessages = [
                    'name.required' => 'Name field is required',
                    'name.regex' => 'Valid name is required',
                    'address.required' => 'Address field is required',
                    'address.max' => 'Maximum character of Address is 255',
                    'city.required' => 'City field is required',
                    'city.max' => 'Maximum character of City is 255',
                    'state.required' => 'State field is required',
                    'state.max' => 'Maximum character of State is 255',
                    'country.required' => 'Country field is required',
                    'country.max' => 'Country character of Country is 255',
                    'pincode.required' => 'Pincode field is required',
                    'pincode.max' => 'Maximum character of Pincode is 255',
                    'admin_mobile.required' => 'Mobile is required',
                    'admin_mobile.numeric' => 'Mobile just can be filled with number',
                    'admin_mobile.digits_between' => 'Mobile length is from 8 to 15 digits',
                ];

                // Upload Admin Photo
                if ($request->hasFile('vendor_image')) {
                    $image_temp = $request->file('vendor_image');
                    if ($image_temp->isValid()) {

                        // Get Image Extension
                        $extension = $image_temp->getClientOriginalExtension();

                        // Generate File Named
                        $imageName = rand(111, 99999) . '.' . $extension;
                        $imagePath = 'admin/images/photos/' . $imageName;

                        Image::make($image_temp)->save($imagePath);
                    }
                } else if (!empty($data['current_vendor_image'])) {
                    $imageName = $data['current_vendor_image'];
                } else {
                    $imageName = "";
                }


                $this->validate($request, $rules, $customMessages);
                // Update in Admin table
                Admin::where('email', $data['email'])->update([
                    'name' => $data['name'],
                    'mobile' => $data['admin_mobile'],
                    'image' => $imageName
                ]);

                // Update in Vendor Table
                Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->update([
                    'name' => $data['name'],
                    'address' => $data['address'],
                    'city' => $data['city'],
                    'state' => $data['state'],
                    'country' => $data['country'],
                    'pincode' => $data['pincode'],
                    'mobile' => $data['admin_mobile']
                ]);

                return redirect()->back()->with('success_message', 'Vendor Personal Details has been updated successfully');
            }


            $vendorDetails = Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        } else if ($slug == "business") {
            if ($request->isMethod('POST')) {

                $data = $request->all();

                //echo "<pre>"; print_r($data); die;


                $rules = [

                    'shop_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'shop_city' => 'required',
                    'shop_mobile' => 'required|numeric|digits_between:8,15',
                    'address_proof' => 'required',


                ];


                $customMessages = [
                    'shop_name.required' => 'Name field is required',
                    'shop_name.regex' => 'Valid Name is required',
                    'shop_city.required' => 'Shop City field is required',
                    'shop_mobile.required' => 'Mobile is required',
                    'shop_mobile.numeric' => 'Mobile just can be filled with number',
                    'shop_mobile.digits_between' => 'Mobile length is from 8 to 15 digits',
                    'address_proof.required' => 'Address Proof field is required',

                ];

                // Upload Admin Photo
                if ($request->hasFile('address_proof_image')) {
                    $image_temp = $request->file('address_proof_image');
                    if ($image_temp->isValid()) {

                        // Get Image Extension
                        $extension = $image_temp->getClientOriginalExtension();

                        // Generate File Named
                        $imageName = rand(111, 99999) . '.' . $extension;
                        $imagePath = 'admin/images/proofs/' . $imageName;

                        Image::make($image_temp)->save($imagePath);
                    }
                } else if (!empty($data['current_address_proof_image'])) {
                    $imageName = $data['current_address_proof_image'];
                } else {
                    $imageName = "";
                }


                $this->validate($request, $rules, $customMessages);
                // // Update in Admin table
                // Admin::where('email', $data['email'])->update([
                //     'name' => $data['name'],
                //     'mobile' => $data['admin_mobile'],
                //     'image' => $imageName
                // ]);

                // Update in vendors_business_details Table
                VendorsBusinessDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update([
                    'shop_name' => $data['shop_name'],
                    'shop_address' => $data['shop_address'],
                    'shop_city' => $data['shop_city'],
                    'shop_state' => $data['shop_state'],
                    'shop_country' => $data['shop_country'],
                    'shop_pincode' => $data['shop_pincode'],
                    'shop_mobile' => $data['shop_mobile'],
                    'shop_website' => $data['shop_website'],

                    'address_proof' => $data['address_proof'],
                    'address_proof_image' => $imageName,
                    'business_license_number' => $data['business_license_number'],
                    'gst_number' => $data['gst_number'],
                    'pan_number' => $data['pan_number'],

                ]);

                return redirect()->back()->with('success_message', 'Vendor Business Details has been updated successfully');
            }

            $vendorDetails = VendorsBusinessDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        } else if ($slug == "bank") {

            if ($request->isMethod('POST')) {

                $data = $request->all();

                //echo "<pre>"; print_r($data); die;


                $rules = [

                    'account_holder_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'bank_name' => 'required',
                    'account_number' => 'required|numeric',
                    'bank_ifsc_code' => 'required',

                ];


                $customMessages = [
                    'account_holder_name.required' => 'Account Holder Number field is required',
                    'account_holder_name.regex' => 'Valid Account Holder Number is required',
                    'bank_name.required' => 'Bank Name field is required',
                    'account_number.required' => 'Account Number field is required',
                    'account_number.numeric' => 'Valid Account Number is required',
                    'bank_ifsc_code.required' => 'Bank IFSC field is required',

                ];




                $this->validate($request, $rules, $customMessages);
                // Update in Admin table


                // Update in Vendor Table
                VendorsBankDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update([
                    'account_holder_name' => $data['account_holder_name'],
                    'bank_name' => $data['bank_name'],
                    'account_number' => $data['account_number'],
                    'bank_ifsc_code' => $data['bank_ifsc_code'],

                ]);

                return redirect()->back()->with('success_message', 'Vendor Bank Details has been updated successfully');
            }

            $vendorDetails = VendorsBankDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        }


        return view('admin.settings.update_vendor_details')->with(compact('slug', 'vendorDetails'));
    }


    public function checkCurrentPassword(Request $request)
    {
        $data = $request->all();
        if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
            return "true";
        } else {
            return "false";
        }
    }


    public function admins($type = null)
    {
        $admins = Admin::query();

        if (!empty($type)) {
            $admins = $admins->where('type', $type);
            $title = ucfirst($type) . "s";
        } else {
            $title = "Admins / Subadmins / Vendors";
        }
        $admins = $admins->get()->toArray();

        //dd($admins);
        return view('admin.admins.admins')->with(compact('admins', 'title'));
    }

    public function viewVendorDetails($id)
    {
        $vendorDetails = Admin::with('vendorPersonal', 'vendorBusiness', 'vendorBank')->where('id', $id)->first();
        $vendorDetails = json_decode(json_encode($vendorDetails), true);
        //dd($vendorDetails);
        return view('admin.admins.view_vendor_details')->with(compact('vendorDetails'));
    }


    public function updateAdminStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Admin::where('id', $data['admin_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'admin_id' => $data['admin_id']]);
        }
    }
}
