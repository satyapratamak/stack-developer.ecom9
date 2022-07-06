@extends('admin.layout.layout')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h4 class="card-title">{{ $card_title }}</h4>
                        
                        
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
                  @if (empty($banner['id']))
                    action="{{ url('/admin/add-edit-banner') }}"
                  @else
                    action="{{ url('/admin/add-edit-banner/'.$product['id']) }}"
                    
                  @endif
                   method="post"
                  name="addEditBannerForm" id="addEditBannerForm" enctype="multipart/form-data"> @csrf
                    
                    <!-- Banner Image -->
                    <div class="form-group">
                      <label for="image">Banner Image (Recommend size 1000x1000)</label>
                      <input type="file" class="form-control" id="image" name="image" />
                      @if (!empty($banner['image']))
                        <a target="_blank" href=" {{ url('front/images/banner_images/'.$banner['image']) }}" >View Image</a>&nbsp;|&nbsp;
                        <a href="javascript:void(0)" class="confirmDelete" module="banner-image" moduleid="{{ $banner['id'] }}">
                          Delete Image
                        </a> 
                        
                      @endif
                    </div>


                    <!-- Banner Link -->
                    <div class="form-group">
                      <label for="link">Link</label>
                      <input type="text" class="form-control" 
                      
                      @if (!empty($banner['link']))
                        value="{{ $banner['link'] }}"                        
                      @else
                        value="{{ old('link') }}"                          
                      @endif     
                      
                      id="link" name="link" placeholder="Please Enter Banner Link">
                    </div>

                    <!-- Banner Title -->
                    <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" class="form-control" 
                      
                      @if (!empty($banner['title']))
                        value="{{ $banner['title'] }}"                        
                      @else
                        value="{{ old('title') }}"                          
                      @endif     
                      
                      id="title" name="title" placeholder="Please Enter Banner Title">
                    </div>


                    <!-- Banner Alt -->
                    <div class="form-group">
                      <label for="alt">Alt</label>
                      <input type="text" class="form-control" 
                      
                      @if (!empty($banner['alt']))
                        value="{{ $banner['alt'] }}"                        
                      @else
                        value="{{ old('alt') }}"                          
                      @endif     
                      
                      id="alt" name="alt" placeholder="Please Enter Banner Alt">
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