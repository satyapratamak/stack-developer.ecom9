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
                  @if (empty($filter_values['id']))
                    action="{{ url('/admin/add-edit-filters-value') }}"
                  @else
                    action="{{ url('/admin/add-edit-filters-value/'.$filter_values['id']) }}"
                    
                  @endif
                   method="post"
                  name="addEditProductFiltersValuesForm" id="addEditProductFiltersValuesForm" enctype="multipart/form-data"> @csrf
                    
                    <div class="form-group">
                      <label for="product_filters_id">Filters</label>
                      <select name="product_filters_id" id="product_filters_id" class="form-control text-dark">                         <option value="">-- Select Category --</option>
                          @foreach ($filters as $filter)
                              <option value="{{ $filter['id'] }}"
                                @if(!empty($filter_values['product_filters_id']) && $filter_values['product_filters_id'] == $filter['id'])
                                  selected=""
                                @endif
                              > &nbsp;&nbsp;&nbsp; --&nbsp;{{ $filter['filter_name'] }} </option>                              
                            
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
                      <label for="filter_name">Filter Value</label>
                      <input type="text" class="form-control" 
                      
                      @if (!empty($filter_values['filter_value']))
                        value="{{ $filter_values['filter_value']}}"                        
                      @else
                        value="{{ old('filter_value') }}"                          
                      @endif     
                      
                      id="filter_value" name="filter_value" placeholder="Please Enter Filter Value">
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