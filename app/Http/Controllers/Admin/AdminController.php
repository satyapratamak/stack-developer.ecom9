<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

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

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }

    public function updateAdminPassword(Request $request)
    {
        // echo "<pre>"; print_r(Auth::guard('admin')->user()); die;
        
        if ($request->isMethod('post')){
            $data = $request->all();
            
            // Check if current password entered by admin is correct
            if(Hash::check($data['current_password'], Auth::guard('admin')->user()->password)){
                //Check if new password is matching with confirm password
                if ($data['new_password'] == $data['confirm_password']){
                    Admin::where('email', $data['email'])->update(['password' => bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success_message', 'Your password has been updated successfully');
                }else{
                    return redirect()->back()->with('error_message', 'New Password and Confirm Password are not match');
                }
            }else{
                return redirect()->back()->with('error_message', 'Your current password is Incorrect');
            }
        }
        
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update_admin_password')->with(compact('adminDetails'));
    }


    public function checkCurrentPassword(Request $request){
        $data = $request->all();
       if(Hash::check($data['current_password'], Auth::guard('admin')->user()->password)){
           return "true";
       }else{
           return "false";
       }

    }
}
