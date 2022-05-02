@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">     
            
            
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Categories</h4>
                  {{-- <p class="card-description">
                    Add class <code>.table-bordered</code>
                  </p> --}}
                  <a 
                  style="max-width:150px; float: right; display:inline-block"
                  href="{{ url('admin/add-edit-category')}}" class="btn btn-block btn-primary"> Add Category</a>

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
                    <table id="categories" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            ID
                          </th>
                          <th>
                            Name
                          </th>

                          <th>
                            Parent
                          </th>

                          <th>
                            Section
                          </th> 
                          
                          <th>
                            Image
                          </th>

                          <th>
                            Discount
                          </th>

                          <th>
                            Description
                          </th>

                          <th>
                            URL
                          </th>

                          <th>
                            Meta Title
                          </th>

                          <th>
                            Meta Description
                          </th>

                          <th>
                            Meta Keywords
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
                        @foreach ($categories as $category)
                          
                        @if (isset($category['parent_category']['category_name']) && !empty($category['parent_category']['category_name']))
                            
                        {{ $parent_category = $category['parent_category']['category_name'] }}
                        
                        @else
                        {{ $parent_category = "Root" }}    
                        
                        @endif
                        
                        <tr>
                          <td>
                            {{ $category['id'] }}
                          </td>
                          <td>
                             {{ $category['category_name'] }}
                          </td>

                          <td>
                            {{ $parent_category }}
                          </td>

                          <td>
                            {{ $category['section']['name'] }}
                          </td>

                          <td>
                            {{ $category['category_image'] }}
                          </td>

                          <td>
                            {{ $category['category_discount'] }}
                          </td>

                          <td>
                            {{ $category['description'] }}
                          </td>

                          <td>
                            {{ $category['url'] }}
                          </td>

                          <td>
                            {{ $category['meta_title'] }}
                          </td>

                          <td>
                            {{ $category['meta_description'] }}
                          </td>

                          <td>
                            {{ $category['meta_keywords'] }}
                          </td>
                          

                          <td>
                            @if($category['status'] == 1)

                              <a class="updateCategoryStatus" id="category-{{ $category['id'] }}" category_id ="{{ $category['id'] }}" href="javascript:void(0)">
                                <i style="font-size:25px" class="mdi mdi-bookmark-check" status="Active"> </i>
                              </a>
                            @else
                              <a class="updateCategoryStatus" id="category-{{ $category['id'] }}" category_id ="{{ $category['id'] }}" href="javascript:void(0)">
                                <i style="font-size:25px" class="mdi mdi-bookmark-outline" status="InActive"> </i>
                              </a>
                            @endif
                            
                          </td>
                          
                                             
                          <td>
                           
                              <a href="{{ url('admin/add-edit-category/'.$category['id']) }}">
                                <i style="font-size:25px" class="mdi mdi-pencil-box"> </i>
                              </a>

                              {{-- <a title="Section" class="confirmDelete" href="{{ url('admin/delete-section/'.$section['id']) }}">
                                <i style="font-size:25px" class="mdi mdi-file-excel-box"> </i>
                              </a> --}}
                              <a href="javascript:void(0)" class="confirmDelete" module="category" moduleid="{{ $category['id'] }}">
                                <i style="font-size:25px" class="mdi mdi-file-excel-box"> </i>
                              </a> 
                            
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