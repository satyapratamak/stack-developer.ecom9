<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductFilters;
use App\Models\ProductFiltersValues;
use Illuminate\Support\Facades\Session;

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
}
