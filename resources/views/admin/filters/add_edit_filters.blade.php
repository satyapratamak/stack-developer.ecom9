@extends('admin.layout.layout')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h4 class="card-title">FILTERS MANAGEMENT</h4>
                        
                        
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                    <a class="dropdown-item" href="#">January - March</a>
                                    <a class="dropdown-item" href="#">March - June</a>
                                    <a class="dropdown-item" href="#">June - August</a>
                                    <a class="dropdown-item" href="#">August - November</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">{{ $title }}</h4>

                  @if(Session::has('error_message'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>ERROR : </strong> <br>
                    {{ Session::get('error_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @endif

                  @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>SUCCESS : </strong> <br>
                    {{ Session::get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @endif

                  @if ($errors->any())
                  {{-- <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div> --}}

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            
                            <strong>ERROR : </strong> 
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        
                        </div>
                    @endif
                  
                  <form class="forms-sample" 
                  @if (empty($filter['id']))
                    action="{{ url('/admin/add-edit-filters') }}"
                  @else
                    action="{{ url('/admin/add-edit-filters/'.$filter['id']) }}"
                    
                  @endif
                   method="post"
                  name="addEditProductFiltersForm" id="addEditProductFiltersForm" enctype="multipart/form-data"> @csrf
                    
                    <div class="form-group">
                      <label for="category_id">Category</label>
                      <select name="category_id[]" id="category_id" class="form-control text-dark" multiple="" style="height:200px">                         <option value="">-- Select Category --</option>
                          @foreach ($categories as $section )
                            <optgroup label="{{ $section['name'] }}"></optgroup>
                            @foreach ( $section['categories'] as $category)
                              <option value="{{ $category['id'] }}"
                                @if(!empty($product['category_id']) && $product['category_id'] == $category['id'])
                                  selected=""
                                @endif
                              > &nbsp;&nbsp;&nbsp; --&nbsp;{{ $category['category_name'] }} </option>
                              @foreach ($category['sub_categories'] as $sub_category )
                                  <option value="{{ $sub_category['id'] }}"
                                  @if(!empty($product['category_id']) && $product['category_id'] == $sub_category['id'])
                                    selected=""
                                  @endif
                                  > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp;{{ $sub_category['category_name'] }} </option>
                              @endforeach
                            @endforeach  
                          @endforeach
                      </select>                      
                    </div>

                    {{-- <div class="form-group">
                      <label for="filter_id">Filter Name</label>
                      <select name="brand_id" id="brand_id" class="form-control text-dark">
                          <option value="">-- Select Brand --</option>
                          @foreach ($brands as $brand )
                            <option value="{{ $brand['id']}}"
                              @if(!empty($product['brand_id']) && $product['brand_id'] == $brand['id'])
                                selected=""
                              @endif
                            
                            > {{ $brand['name'] }}</option>
                             
                          @endforeach
                      </select>                      
                    </div> --}}

                    {{-- Filter Name --}}
                    <div class="form-group">
                      <label for="filter_name">Filter Name</label>
                      <input type="text" class="form-control" 
                      
                      @if (!empty($filter['filter_name']))
                        value="{{ $filter['filter_name'] }}"                        
                      @else
                        value="{{ old('filter_name') }}"                          
                      @endif     
                      
                      id="filter_name" name="filter_name" placeholder="Please Enter Filter Name">
                    </div>

                    {{-- Filter Column --}}
                    <div class="form-group">
                      <label for="filter_column">Filter Column</label>
                      <input type="text" class="form-control" 
                      
                      @if (!empty($filter['filter_column']))
                        value="{{ $filter['filter_column'] }}"                        
                      @else
                        value="{{ old('filter_column') }}"                          
                      @endif     
                      
                      id="filter_column" name="filter_column" placeholder="Please Enter Filter Column">
                    </div>
                    

                    
                    
                    {{-- <div class="form-group">
                      <label for="is_featured">Featured Items</label>
                      <input type="checkbox" name="is_featured" value="Yes" 
                        @if(!empty($product['is_featured']) && $product['is_featured'] == 'Yes')
                            checked="checked"                       
                            
                        @endif
                        
                      />
                      
                    </div>  --}}

                    {{-- <div class="form-group">
                      <label for="is_bestseller">Best Seller Items</label>
                      <input type="checkbox" name="is_bestseller" value="Yes" 
                        @if(!empty($product['is_bestseller']) && $product['is_bestseller'] == 'Yes')
                            checked="checked"                       
                            
                        @endif
                        
                      />
                      
                    </div>  --}}                 
                    
                    
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>     
            
          </div>
    </div>
    <!-- content-wrapper ends -->
    
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>
@endsection