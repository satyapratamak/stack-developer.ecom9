@extends('admin.layout.layout')
@section('content')
<?php
use App\Models\ProductFilters;
?>
<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">     
            
            
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3 class="font-weight-bold">PRODUCT FILTERS MANAGEMENT</h3>
                  <h4 class="card-title">Filters Values</h4>
                  {{-- <p class="card-description">
                    Add class <code>.table-bordered</code>
                  </p> --}}

                  <a 
                  style="max-width:150px; float: left; display:inline-block"
                  href="{{ url('admin/filters')}}" class="btn btn-block btn-primary"> View Filters</a>
                  <a 
                  style="max-width:150px; float: right; display:inline-block"
                  href="{{ url('admin/add-edit-filters')}}" class="btn btn-block btn-primary"> Add Filters Value</a>

                  @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>SUCCESS : </strong> <br>
                    {{ Session::get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @endif
                  <div class="table-responsive pt-3">
                    <table id="filters" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            ID
                          </th>
                          <th>
                            Filter Name
                          </th>
                          
                          <th>
                            Filter Value
                          </th>  
                                                   
                          <th>
                            Status
                          </th>
                          <th>
                            Actions
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($filters_values as $filters_value)
                          
                        
                        <tr>
                          <td>
                            {{ $filters_value['id'] }}
                            
                          </td>
                          <td>
                            {{-- {{ $filters_value['product_filters_id'] }} --}}

                            <?php
                              echo ProductFilters::getProductFiltersName($filters_value['product_filters_id']);
                            ?>
                          </td>
                          <td>
                            {{ $filters_value['filter_value'] }}
                          </td>
                          

                          <td>
                            @if($filters_value['status'] == 1)

                              <a class="updateFilterValuesStatus" id="filter-values-{{ $filters_value['id'] }}" filter_values_id ="{{ $filters_value['id'] }}" href="javascript:void(0)">
                                <i style="font-size:25px" class="mdi mdi-bookmark-check" status="Active"> </i>
                              </a>
                            @else
                              <a class="updateFilterValuesStatus" id="filter-values-{{ $filters_value['id'] }}" filter_values_id ="{{ $filters_value['id'] }}" href="javascript:void(0)">
                                <i style="font-size:25px" class="mdi mdi-bookmark-outline" status="InActive"> </i>
                              </a>
                            @endif
                            
                          </td>
                          
                                             
                          <td>
                           
                              {{-- <a href="{{ url('admin/add-edit-filter/'.$filter['id']) }}">
                                <i style="font-size:25px" class="mdi mdi-pencil-box"> </i>
                              </a>

                              <a title="Brand" class="confirmDelete" href="{{ url('admin/delete-brand/'.$brand['id']) }}">
                                <i style="font-size:25px" class="mdi mdi-file-excel-box"> </i>
                              </a>
                              <a href="javascript:void(0)" class="confirmDelete" module="filter" moduleid="{{ $filter['id'] }}">
                                <i style="font-size:25px" class="mdi mdi-file-excel-box"> </i>
                              </a>  --}}
                            
                          </td>
                          
                        </tr>
                        @endforeach
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            
            
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
         @include('admin.layout.footer')
        <!-- partial -->
      </div>
@endsection