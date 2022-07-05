<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Session;

class BannersController extends Controller
{
    //
    public function banners()
    {
        Session::put('page', 'banners');
        $banners = Banner::get()->toArray();

        return view('admin.banners.banners')->with(compact('banners'));
    }

    public function updateBannerStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Banner::where('id', $data['banner_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'banner_id' => $data['banner_id']]);
        }
    }

    public function deleteBanner($id)
    {
        //Get Banner Name
        $banner = Banner::select('image')->where('id', $id)->first();

        // Get Banner Path

        $banner_path = 'front/images/banner_images/';

        // Delete Banner Images from Banner Images folder
        if (file_exists($banner_path . $banner->image)) {
            unlink($banner_path . $banner->image);
        }



        //Delete Banner Name from banners tables
        Banner::where('id', $id)->delete();

        $message = "Banners has been deleted successfully";
        return redirect()->back()->with('success_message', $message);
    }
}
