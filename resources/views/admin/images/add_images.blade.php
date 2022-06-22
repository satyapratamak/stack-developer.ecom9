@extends('admin.layout.layout')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h4 class="card-title">PRODUCT IMAGES</h4>
                        
                        
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
                 
                    action="{{ url('/admin/add-images/'.$product['id']) }}"
                  
                   method="post"
                  name="addImagesForm" id="addImagesForm" enctype="multipart/form-data"> @csrf
                                    
                    <div class="form-group">
                      <label for="product_name">Product Name</label>

                      <input type="text" class="form-control"                     
                        value="{{ $product['product_name'] }}" disabled="">
                                         
                    </div>

                    <div class="form-group">
                      <label for="product_code">Product Code</label>
                      <input type="text" class="form-control"                     
                        value="{{ $product['product_code'] }}" disabled="">                      
                    </div>

                    <div class="form-group">
                      <label for="product_color">Product Color</label>
                      
                      <input type="text" class="form-control"                     
                        value="{{ $product['product_color'] }}" disabled="">
                                            
                    </div>

                    <div class="form-group">
                      <label for="product_price">Product Price</label>
                      <input type="text" class="form-control"                     
                        value="{{ $product['product_price'] }}" disabled="">
                    </div>                   

                    <div class="form-group">
                      <label for="product_image">Product Image</label>
                      
                      @if (!empty($product['product_image']))
                        <img class="form-control" style="width:120px; height:120px" src="{{ url('front/images/product_images/medium/'.$product['product_image']) }}" >
                      @else
                        <img class="form-control" style="width:120px; height:120px" src="{{ url('front/images/product_images/small/no-image.png')}}" >
                      @endif
                    </div>

                    <div class="form-group">
                      <label for="product_weight">Images</label>
                      <div class="field_wrapper">
                          
                              <input type="file" name="images[]" multiple="" required=""/>
                                                       
                      </div>
                    </div>
                   
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
                  </form>
                  <br>
                  <h4 class="card-title">Product Images</h4>
                  <div class="table-responsive pt-3">
                  
                    <table id="attributes" class="table table-bordered">
                          <thead>
                      <tr>
                        <th>
                          ID
                        </th>
                        <th>
                          Image
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

                      

                      @foreach ($product['images'] as $image)
                            
                      <tr>
                        {{-- <td>
                          {{ $attributes['id'] }}
                          <input type="hidden" value="{{ $attributes['id'] }}" id="attributeId" name="attributeId[]">
                        </td> --}}

                        
                        <td>                            
                          {{ $image['id'] }}
                            
                        </td>

                        <td>                            
                          <img class="form-control" src="{{ url('front/images/product_images/small/'.$image['image']) }}" >
                            
                        </td>

                        
                        
                        
                        <td>
                            @if($image['status'] == 1)

                              <a class="updateImagesStatus" id="image-{{ $image['id'] }}" image_id ="{{ $image['id'] }}" href="javascript:void(0)">
                                <i style="font-size:25px" class="mdi mdi-bookmark-check" status="Active"> </i>
                              </a>
                            @else
                              <a class="updateImagesStatus" id="image-{{ $image['id'] }}" image_id ="{{ $image['id'] }}" href="javascript:void(0)">
                                <i style="font-size:25px" class="mdi mdi-bookmark-outline" status="InActive"> </i>
                              </a>
                            @endif
                            
                          </td>
                                            
                        <td>
                          
                            <a href="{{ url('admin/add-edit-product/'.$image['id']) }}">
                              <i style="font-size:25px" class="mdi mdi-pencil-box"> </i>
                            </a>

                            <a href="{{ url('admin/add-edit-image/'.$image['id']) }}">
                              <i style="font-size:25px" class="mdi mdi-plus-box"> </i>
                            </a>
                            
                            <a href="javascript:void(0)" class="confirmDelete" module="image" moduleid="{{ $image['id'] }}">
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
    
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>
@endsection