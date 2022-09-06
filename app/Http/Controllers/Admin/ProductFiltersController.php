<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductFilters;
use App\Models\ProductFiltersValues;
use Illuminate\Support\Facades\Session;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class ProductFiltersController extends Controller
{
    //
    public function filters()
    {
        Session::put('page', 'filters');
        $filters = ProductFilters::get()->toArray();

        return view('admin.filters.filters')->with(compact('filters'));
    }

    public function filtersValues()
    {
        Session::put('page', 'filters-values');
        $filters_values = ProductFiltersValues::get()->toArray();

        return view('admin.filters.filters_values')->with(compact('filters_values'));
    }

    public function updateFiltersStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            ProductFilters::where('id', $data['filter_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'filter_id' => $data['filter_id']]);
        }
    }

    public function updateFiltersValuesStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            ProductFiltersValues::where('id', $data['filter_values_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'filter_values_id' => $data['filter_values_id']]);
        }
    }

    public function addEditFilters(Request $request, $id = null)
    {
        Session::put('page', 'filters');
        if ($id == "") {
            $title = "Add Filter";
            $filter = new ProductFilters();
            $message = "Product Filter added successfully";
        } else {
            $title = "Add Filter";
            $filter = ProductFilters::find($id);
            $message = "Product Filter added successfully";
        }

        if ($request->isMethod('POST')) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            $category_id = implode(',', $data['category_id']);

            // Save to product_filter table
            $filter->category_id = $category_id;
            $filter->filter_name = $data['filter_name'];
            $filter->filter_column = $data['filter_column'];
            $filter->status = 1;
            $filter->save();

            DB::statement('Alter table products add ' . $data['filter_column'] . " varchar(255) after description");
            return redirect('admin/filters')->with('success_message', $message);
        }

        $categories = Section::with('categories')->get()->toArray();

        return view('admin.filters.add_edit_filters')->with(compact('categories', 'title', 'filter', 'message'));
    }
}
