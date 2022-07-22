<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

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

    public function addEditBanner(Request $request, $id = null)
    {
        Session::put('page', 'add-edit-banner');
        $title = "";
        $card_title = "HOME PAGE BANNERS";


        if ($id == "") {
            $title = "Add Banners";
            $banner = new Banner;
            $message = "Banner added successfully";
        } else {
            $title = "Edit Banners";
            $banner = Banner::find($id);
            $message = "Banner edited successfully";
        }

        if ($request->isMethod('POST')) {
            $data = $request->all();


            if ($data['type'] == "Slider") {
                $image_width = 1920;
                $image_height = 720;
            } else  if ($data['type'] == "Fix") {
                $image_width = 1920;
                $image_height = 450;
            }

            if ($request->hasFile('image')) {
                $image_temp = $request->file('image');
                if ($image_temp->isValid()) {

                    // Get Image Extension
                    $extension = $image_temp->getClientOriginalExtension();

                    // Generate File Named
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'front/images/banner_images/' . $imageName;

                    Image::make($image_temp)->resize($image_width, $image_height)->save($imagePath);
                    $banner->image = $imageName;
                }
            } else {
                $banner->image = "";
            }

            if (empty($data['link'])) {
                $data['link'] = "";
            }
            if (empty($data['title'])) {
                $data['title'] = "";
            }
            if (empty($data['alt'])) {
                $data['alt'] = "";
            }
            $banner->link = $data['link'];
            $banner->title = $data['title'];
            $banner->alt = $data['alt'];
            $banner->type = $data['type'];
            $banner->status = 1;

            $banner->save();

            return redirect('admin/banners')->with('success_message', $message);
        }



        return view('admin.banners.add_edit_banner')->with(compact('title', 'card_title', 'banner'));
    }
}
