<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function categories()
    {
        Session::put('page', 'categories');
        $categories = Category::with(['section', 'parentCategory'])->get()->toArray();
        //dd($categories);
        return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request)
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
            Category::where('id', $data['category_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'category_id' => $data['category_id']]);
        }
    }

    public function addEditCategory(Request $request, $id = null)
    {
        Session::put('page', 'categories');
        if ($id == "") {
            $title = "Add Category";
            $category = new Category;
            $getCategories = array();
            $message = "Category added successfully";
        } else {
            $title = "Edit Category";
            $category = Category::find($id);
            $getCategories = Category::with('subCategories')->where(['parent_id' => 0, 'section_id' => $category['section_id']])->get();
            $message = "Category updated successfully";

            // //dd($category);

            // echo "<pre>";
            // print_r($category);
            // die;
        }

        if ($request->isMethod('POST')) {
            $data = $request->all();

            if ($data['category_discount'] == "") {
                $data['category_discount'] = 0;
            }
            // echo "<pre>";
            // print_r($data);
            // die;

            // Upload Admin Photo
            // if ($request->hasFile('category_image')) {
            //     $image_temp = $request->file('category_image');
            //     if ($image_temp->isValid()) {

            //         // Get Image Extension
            //         $extension = $image_temp->getClientOriginalExtension();

            //         // Generate File Named
            //         $imageName = rand(111, 99999) . '.' . $extension;
            //         $imagePath = 'front/images/category_images/' . $imageName;

            //         Image::make($image_temp)->save($imagePath);
            //         $category->category_image = $imageName;
            //     }
            // } else if (!empty($data['current_category_image'])) {
            //     $imageName = $data['current_category_image'];
            // } else {
            //     $imageName = "";
            // }

            if ($request->hasFile('category_image')) {
                $image_temp = $request->file('category_image');
                if ($image_temp->isValid()) {

                    // Get Image Extension
                    $extension = $image_temp->getClientOriginalExtension();

                    // Generate File Named
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'front/images/category_images/' . $imageName;

                    Image::make($image_temp)->save($imagePath);
                    $category->category_image = $imageName;
                }
            } else {
                $category->category_image = "";
            }

            $category->parent_id = $data['parent_id'];
            $category->category_name = $data['category_name'];
            $category->section_id = $data['section_id'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();

            return redirect('admin/categories')->with('success_message', $message);
        }

        $getSection = Section::get()->toArray();

        return view('admin.categories.add_edit_category')->with(compact('title', 'category', 'getSection', 'getCategories'));
    }
    //
    public function appendCategoriesLevel(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $getCategories = Category::with('subCategories')->where(['parent_id' => 0, 'section_id' => $data['section_id']])->get()->toArray();
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
            //$msg = "This is a simple message.";
            // return response()->json(array('msg' => $msg), 200);
        }
    }
}
