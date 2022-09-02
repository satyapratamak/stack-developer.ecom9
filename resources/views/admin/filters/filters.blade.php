@extends('admin.layout.layout')
@section('content')

<?php
use App\Models\Category;
?>
<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">     
            
            
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3 class="font-weight-bold">PRODUCT FILTERS MANAGEMENT</h3>
                  <h4 class="card-title">Filters</h4>
                  {{-- <p class="card-description">
                    Add class <code>.table-bordered</code>
                  </p> --}}
                  <a 
                  style="max-width:160px; float: left; display:inline-block"
                  href="{{ url('admin/filters-values')}}" class="btn btn-block btn-primary"> View Filters Values</a>

                  <a 
                  style="max-width:150px; float: right; display:inline-block"
                  href="{{ url('admin/add-edit-filters')}}" class="btn btn-block btn-primary"> Add Filters</a>

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
                            Category Name
                          </th>
                          
                          <th>
                            Filter Name
                          </th>  
                           <th>
                            Filter Column
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
                        @foreach ($filters as $filter)
                          
                        
                        <tr>
                          <td>
                            {{ $filter['id'] }}
                          </td>
                          <td>
                            {{-- {{ $filter['category_id'] }} --}}
                            <?php 
                              $catIds = explode(",", $filter['category_id'] );
                              foreach ($catIds as $key=>$catId){
                                $category_name = Category::getCategoryName($catId);
                                echo $category_name."<br>";
                              }
                            ?>
                          </td>
                          <td>
                            {{ $filter['filter_name'] }}
                          </td>
                          <td>
                            {{ $filter['filter_column'] }}
                          </td>

                          <td>
                            @if($filter['status'] == 1)

                              <a class="updateFilterStatus" id="filter-{{ $filter['id'] }}" filter_id ="{{ $filter['id'] }}" href="javascript:void(0)">
                                <i style="font-size:25px" class="mdi mdi-bookmark-check" status="Active"> </i>
                              </a>
                            @else
                              <a class="updateFilterStatus" id="filter-{{ $filter['id'] }}" filter_id ="{{ $filter['id'] }}" href="javascript:void(0)">
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