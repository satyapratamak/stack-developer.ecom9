<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductsAttributes;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    //
    public function products()
    {
        Session::put('page', 'products');
        $products = Product::with(
            [
                'section' => function ($query) {
                    $query->select('id', 'name');
                },
                'category' => function ($query) {
                    $query->select('id', 'category_name');
                },
            ]
        )->get()->toArray();
        //dd($products);
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request)
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
            Product::where('id', $data['product_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'product_id' => $data['product_id']]);
        }
    }

    public function deleteProduct($id)
    {
        // Delete Category based on id
        Product::where('id', $id)->delete();
        $message = "Product has been deleted successfully";
        return redirect()->back()->with('success_message', $message);
    }

    public function addEditProduct(Request $request, $id = null)
    {
        Session::put('page', 'products');
        if ($id == "") {
            $title = "Add Product";
            $product = new Product;
            $message = "Product added successfully";
        } else {
            $title = "Edit Product";
            $product = Product::find($id);
            $message = "Product edited successfully";
        }

        if ($request->isMethod('POST')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die();

            $rules = [
                'category_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required|regex:/^\w+$/',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u',

            ];


            $customMessages = [
                'category_id.required' => 'Category is required',
                'product_name.required' => 'Product Name is required',
                'product_name.regex' => 'Valid Product Name is required',
                'product_code.required' => 'Product Code is required',
                'product_code.regex' => 'Valid Product Code is required',
                'product_price.required' => 'Product Price is required',
                'product_price.numeric' => 'Product Price must be fulfilled with number',
                'product_color.required' => 'Product Color is required',
                'product_color.regex' => 'Valid Product Color is required',

            ];

            $this->validate($request, $rules, $customMessages);

            // Upload Product Image after resize
            // Small : 250x250
            // Medium : 500x500
            // Large :1000x1000

            if ($request->hasFile('product_image')) {
                $image_tmp = $request->file('product_image');
                if ($image_tmp->isValid()) {

                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();

                    // Generate File Named
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $largeImagePath = 'front/images/product_images/large/' . $imageName;
                    $mediumImagePath = 'front/images/product_images/medium/' . $imageName;
                    $smallImagePath = 'front/images/product_images/small/' . $imageName;

                    // Upload Large, Medium and Small Product Images after Resize
                    Image::make($image_tmp)->resize(1000, 1000)->save($largeImagePath);
                    Image::make($image_tmp)->resize(500, 500)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(250, 250)->save($smallImagePath);

                    $product->product_image = $imageName;
                }
            }

            // Upload Product Video


            if ($request->hasFile('product_video')) {
                $video_tmp = $request->file('product_video');
                if ($video_tmp->isValid()) {

                    // Upload video to folder
                    $video_name = $video_tmp->getClientOriginalName();
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = $video_name . '-' . rand() . '.' . $extension;
                    $videoPath = 'front/videos/product_videos/';
                    $video_tmp->move($videoPath, $videoName);

                    // Insert Video name to products table
                    $product->product_video = $videoName;
                }
            }

            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];

            $product->admin_type = Auth::guard('admin')->user()->type;

            $product->admin_id = Auth::guard('admin')->user()->id;

            if (Auth::guard('admin')->user()->type == "vendor") {
                $product->vendor_id = Auth::guard('admin')->user()->vendor_id;
            } else {
                $product->vendor_id = 0;
            }

            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];

            if (!empty($data['is_featured'])) {
                $product->is_featured = "Yes";
            } else {
                $product->is_featured = "No";
            }
            $product->status = 1;
            $product->save();
            return redirect('admin/products')->with('success_message', $message);
        }




        // Save Data to products table

        // Get Section with Categories and Sub Categories
        $categories = Section::with('categories')->get()->toArray();
        //dd($categories);
        $brands = Brand::where('status', 1)->get()->toArray();
        return view('admin.products.add_edit_product')->with(compact('title', 'categories', 'brands', 'product'));
    }

    public function deleteProductImage($id)
    {
        //Get Product Image Name
        $productImage = Product::select('product_image')->where('id', $id)->first();

        // Get Product Image Path
        $small_image_path = 'front/images/product_images/small/';
        $medium_image_path = 'front/images/product_images/medium/';
        $large_image_path = 'front/images/product_images/large/';

        // Delete Small Product Image in Small folder
        if (file_exists($small_image_path . $productImage->product_image)) {
            unlink($small_image_path . $productImage->product_image);
        }

        // Delete Medium Product Image in medium folder
        if (file_exists($medium_image_path . $productImage->product_image)) {
            unlink($medium_image_path . $productImage->product_image);
        }

        // Delete Large Product Image in large folder
        if (file_exists($large_image_path . $productImage->product_image)) {
            unlink($large_image_path . $productImage->product_image);
        }

        //Delete PRoduct Image Name from products tables
        Product::where('id', $id)->update(['product_image' => '']);

        $message = "Product Image has been deleted successfully";
        return redirect()->back()->with('success_message', $message);
    }

    public function deleteProductVideo($id)
    {
        //Get Product Image Name
        $productVideo = Product::select('product_video')->where('id', $id)->first();

        // Get Product Video Path
        $video_path = 'front/videos/product_videos/';


        // Delete Small Product Image in Small folder
        if (file_exists($video_path . $productVideo->product_video)) {
            unlink($video_path . $productVideo->product_video);
        }



        //Delete PRoduct Image Name from products tables
        Product::where('id', $id)->update(['product_video' => '']);

        $message = "Product Video has been deleted successfully";
        return redirect()->back()->with('success_message', $message);
    }

    public function addAttributes(Request $request, $id)
    {
        Session::put('page', 'products');
        $product = Product::select('id', 'product_name', 'product_code', 'product_color', 'product_price', 'product_price', 'product_image')->with('attributes')->find($id)->toArray();
        //dd($product);

        if ($request->isMethod('GET')) {
            $title = 'Add Attributes';
        } else {
            $title = 'Edit Attributes';
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            foreach ($data['sku'] as $key => $value) {
                if (!empty($value)) {

                    // SKU Duplication Check
                    $skuCount = ProductsAttributes::where('sku', $value)->count();
                    if ($skuCount > 0) {
                        return redirect()->back()->with('error_message', 'SKU Already Exists! Please add anoter SKU');
                    }

                    // Size Duplication Check
                    $sizeCount = ProductsAttributes::where(['product_id' => $id, 'size' => $data['size'][$key]])->count();
                    if ($sizeCount > 0) {
                        return redirect()->back()->with('error_message', 'Size Already Exists! Please add anoter Size');
                    }

                    $attribute = new ProductsAttributes;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }
            return redirect()->back()->with('success_message', 'Product Atrributes have been added successfully');
        }


        return view('admin.attributes.add_edit_attributes')->with(compact('product', 'title'));
    }

    public function updateAttributesStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            ProductsAttributes::where('id', $data['attributes_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'attributes_id' => $data['attributes_id']]);
        }
    }

    public function editAttributes(Request $request, $product_id)
    {
        if ($request->isMethod('POST')) {

            $data = $request->all();

            // dd($data);

            foreach ($data['attributeId'] as $key => $attributeid) {

                $size = $data['size'][$key];
                $sku = $data['sku'][$key];
                $stock = $data['stock'][$key];
                $price = $data['price'][$key];
                ProductsAttributes::where('id', $attributeid)->where('product_id', $product_id)
                    ->update(['size' => $size, 'price' => $price, 'sku' => $sku, 'stock' => $stock]);
            }

            return redirect()->back()->with('success_message', 'Product Atrributes have been updated successfully');
        }
        // get all request data
    }
}
