@extends('admin.layout.layout')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h4 class="card-title">PRODUCT</h4>
                        
                        
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
                  @if (empty($product['id']))
                    action="{{ url('/admin/add-edit-product') }}"
                  @else
                    action="{{ url('/admin/add-edit-product/'.$product['id']) }}"
                    
                  @endif
                   method="post"
                  name="addEditProductForm" id="addEditProductForm" enctype="multipart/form-data"> @csrf
                    
                    <div class="form-group">
                      <label for="category_id">Category</label>
                      <select name="category_id" id="category_id" class="form-control text-dark" >                         <option value="">-- Select Category --</option>
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

                    <div class="form-group">
                      <label for="brand_id">Brand Name</label>
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
                    </div>
                    <div class="form-group">
                      <label for="product_name">Product Name</label>
                      <input type="text" class="form-control" 
                      
                      @if (!empty($product['product_name']))
                        value="{{ $product['product_name'] }}"                        
                      @else
                        value="{{ old('product_name') }}"                          
                      @endif     
                      
                      id="product_name" name="product_name" placeholder="Please Enter Product Name">
                    </div>

                    <div class="form-group">
                      <label for="product_code">Product Code</label>
                      <input type="text" class="form-control" 
                      
                      @if (!empty($product['product_code']))
                        value="{{ $product['product_code'] }}"                        
                      @else
                        value="{{ old('product_code') }}"                          
                      @endif     
                      
                      id="product_code" name="product_code" placeholder="Please Enter Product Code">
                    </div>

                    <div class="form-group">
                      <label for="product_color">Product Color</label>
                      <input type="text" class="form-control" 
                      
                      @if (!empty($product['product_color']))
                        value="{{ $product['product_color'] }}"                        
                      @else
                        value="{{ old('product_color') }}"                          
                      @endif     
                      
                      id="product_color" name="product_color" placeholder="Please Enter Product Color">
                    </div>

                    <div class="form-group">
                      <label for="product_price">Product Price</label>
                      <input type="text" class="form-control" 
                      
                      @if (!empty($product['product_price']))
                        value="{{ $product['product_price'] }}"                        
                      @else
                        value="{{ old('product_price') }}"                          
                      @endif     
                      
                      id="product_price" name="product_price" placeholder="Please Enter Product Price">
                    </div>

                    <div class="form-group">
                      <label for="product_discount">Product Discount (%)</label>
                      <input type="text" class="form-control" 
                      
                      @if (!empty($product['product_discount']))
                        value="{{ $product['product_discount'] }}"                        
                      @else
                        value="{{ old('product_discount') }}"                          
                      @endif     
                      
                      id="product_discount" name="product_discount" placeholder="Please Enter Product Discount">
                    </div>

                    <div class="form-group">
                      <label for="product_weight">Product Weight</label>
                      <input type="text" class="form-control" 
                      
                      @if (!empty($product['product_weight']))
                        value="{{ $product['product_weight'] }}"                        
                      @else
                        value="{{ old('product_weight') }}"                          
                      @endif     
                      
                      id="product_weight" name="product_weight" placeholder="Please Enter Product Weight">
                    </div>

                    <div class="form-group">
                      <label for="product_image">Product Image (Recommend size 1000x1000)</label>
                      <input type="file" class="form-control" id="product_image" name="product_image" />
                      @if (!empty($product['product_image']))
                        <a href=" {{ url('front/images/product_images/medium/'.$product['product_image']) }}" >View Image</a>&nbsp;|&nbsp;
                        <a href="javascript:void(0)" class="confirmDelete" module="product-image" moduleid="{{ $product['id'] }}">
                          Delete Image
                        </a> 
                        
                      @endif
                    </div>

                    <div class="form-group">
                      <label for="product_video">Product Video (Recommend Size : Less than 2 MB)</label>
                      <input type="file" class="form-control" id="product_video" name="product_video" />
                      @if (!empty($product['product_video']))
                        <a href=" {{ url('front/videos/product_videos/'.$product['product_video']) }}" >View Video</a>&nbsp;|&nbsp;
                        <a href="javascript:void(0)" class="confirmDelete" module="product-video" moduleid="{{ $product['id'] }}">
                          Delete Video
                        </a> 
                        
                      @endif
                    </div>

                    

                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea class="form-control" id="description"  name="description" rows="3" placeholder="Please enter Description">{{ $product['description'] }}</textarea>
                    </div>

                    <div class="form-group">
                      <label for="meta_title">Meta Title</label>
                      <input type="text" class="form-control" 
                      
                      @if (!empty($product['meta_title']))
                        value="{{ $product['meta_title'] }}"                        
                      @else
                        value="{{ old('meta_title') }}"                        
                      @endif                     
                      
                      id="meta_title" name="meta_title" placeholder="Please Enter Meta Title">
                    </div>

                    <div class="form-group">
                      <label for="meta_description">Meta Description</label>
                      <input type="text" class="form-control" 
                      
                      @if (!empty($product['meta_description']))
                        value="{{ $product['meta_description'] }}"                        
                      @else
                        value="{{ old('meta_description') }}"                        
                      @endif                     
                      
                      id="meta_description" name="meta_description" placeholder="Please Enter Meta Description">
                    </div>

                    <div class="form-group">
                      <label for="meta_keywords">Meta Keywords</label>
                      <input type="text" class="form-control" 
                      
                      @if (!empty($product['meta_keywords']))
                        value="{{ $product['meta_keywords'] }}"                        
                      @else
                        value="{{ old('meta_keywords') }}"                        
                      @endif                     
                      
                      id="meta_keywords" name="meta_keywords" placeholder="Please Enter Meta Keywords">
                    </div>
                    
                    <div class="form-group">
                      <label for="is_featured">Featured Items</label>
                      <input type="checkbox" name="is_featured" value="Yes" 
                        @if(!empty($product['is_featured']) && $product['is_featured'] == 'Yes')
                            checked="checked"                       
                            
                        @endif
                        
                      />
                      
                    </div> 

                    <div class="form-group">
                      <label for="is_bestseller">Best Seller Items</label>
                      <input type="checkbox" name="is_bestseller" value="Yes" 
                        @if(!empty($product['is_bestseller']) && $product['is_bestseller'] == 'Yes')
                            checked="checked"                       
                            
                        @endif
                        
                      />
                      
                    </div> 

                    
                    
                    
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