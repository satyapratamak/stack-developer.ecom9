@extends('admin.layout.layout')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">VENDOR DETAILS</h3>
                        
                    </div>
                    <!--div class="col-12 col-xl-4">
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
                    </div-->
                </div>
            </div>
        </div>

       @if ($slug == "personal")
       <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Personal Details</h4>

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
                  
                  <form class="forms-sample" action="{{ url('/admin/update-vendor-details/personal') }}" method="post"
                  name="updateAdminDetailsForm" id="updateAdminDetailsForm" enctype="multipart/form-data"> @csrf
                    <div class="form-group">
                      <label>Vendor Username / Email</label>
                      <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" id="email" name="email" readonly="">
                    </div>

                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->name }}" id="name" name="name" placeholder="Enter Name" required="">
                      
                    </div>
                    
                    <div class="form-group">
                      <label for="address">Address</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['address'] }}" id="address" name="address" placeholder="Enter Address" required="">
                      
                    </div>

                    <div class="form-group">
                      <label for="city">City</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['city'] }}" id="city" name="city" placeholder="Enter City" required="">
                      
                    </div>

                    <div class="form-group">
                      <label for="state">State</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['state'] }}" id="state" name="state" placeholder="Enter State" required="">
                      
                    </div>

                    <div class="form-group">
                      <label for="country">Country</label>
                      {{-- <input type="text" class="form-control" value="{{ $vendorDetails['country'] }}" id="country" name="country" placeholder="Enter Country" required=""> --}}
                      <select class="form-control" id="country" name="country">
                        <option value="">Select Country</option>
                        @foreach ($countries as $country )
                        <option value="{{ $country['country_name'] }}"
                        @if ($country['country_name'] == $vendorDetails['country'])
                        selected
                        @endif
                        
                        >{{ $country['country_name'] }}</option>
                          
                        @endforeach

                      </select>
                      
                    </div>

                    

                    <div class="form-group">
                      <label for="pincode">Pincode</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['pincode'] }}" id="pincode" name="pincode" placeholder="Enter Pincode">
                      
                    </div>

                    
                    <div class="form-group">
                      <label for="admin_mobile">Mobile</label>
                      <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->mobile }}" id="admin_mobile" name="admin_mobile" 
                      placeholder="Enter minimum 5 digit and maximum 15 digit of mobile number" required="" maxlength="20" minlength="5">
                    </div>

                    <div class="form-group">
                      <label for="vendor_image">Vendor Image</label>
                      <input type="file" class="form-control" id="vendor_image" name="vendor_image">
                      @if(!empty(Auth::guard('admin')->user()->image))
                        <a target="_blank" href="{{ url('admin/images/photos/'.Auth::guard('admin')->user()->image) }}">  View Image </a>
                        <input type="hidden" name="current_vendor_image" value="{{ Auth::guard('admin')->user()->image }}">
                      @endif
                    </div>
                    
                    
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>     
            
        </div>
       @elseif ($slug == "business")
       <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Business Informations</h4>

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
                  
                  <form class="forms-sample" action="{{ url('/admin/update-vendor-details/business') }}" method="post"
                  name="updateVendorBusinessDetailsForm" id="updateVendorBusinessDetailsForm" enctype="multipart/form-data"> @csrf
                    <div class="form-group">
                      <label>Vendor Username / Email</label>
                      <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" id="email" name="email" readonly="">
                    </div>  

                    <div class="form-group">
                      <label for="shop_name">Shop Name</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['shop_name'] }}" id="shop_name" name="shop_name" placeholder="Please Enter Shop Name" required="">
                    </div>

                    <div class="form-group">
                      <label for="shop_address">Shop Address</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['shop_address'] }}" id="shop_address" name="shop_address" placeholder="Please Enter Shop Address" required="">
                    </div>

                    <div class="form-group">
                      <label for="shop_city">Shop City</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['shop_city'] }}" id="shop_city" name="shop_city" placeholder="Please Enter Shop City" required="">
                    </div>

                    <div class="form-group">
                      <label for="shop_state">Shop State</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['shop_state'] }}" id="shop_state" name="shop_state" placeholder="Please Enter Shop State" required="">
                    </div>

                    <div class="form-group">
                      <label for="shop_country">Shop Country</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['shop_country'] }}" id="shop_country" name="shop_country" placeholder="Please Enter Shop Country" required="">
                    </div>

                    <div class="form-group">
                      <label for="shop_pincode">Shop Pincode</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['shop_pincode'] }}" id="shop_pincode" name="shop_pincode" placeholder="Please Enter Shop Pincode" required="">
                    </div>

                    <div class="form-group">
                      <label for="shop_mobile">Shop Mobile</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['shop_mobile'] }}" id="shop_mobile" name="shop_mobile" placeholder="Please Enter Shop Mobile" required="">
                    </div>

                    <div class="form-group">
                      <label for="shop_website">Shop Website</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['shop_website'] }}" id="shop_website" name="shop_website" placeholder="Please Enter Shop Website" required="">
                    </div>

                    {{-- <div class="form-group">
                      <label for="shop_email">Shop Email</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['shop_email'] }}" id="shop_email" name="shop_email" placeholder="Please Enter Shop Email" required="">
                    </div> --}}

                    <div class="form-group">
                      <label for="business_license_number">business_license_number</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['business_license_number'] }}" id="business_license_number" name="business_license_number" placeholder="Please Enter Business License Number" required="">
                    </div>

                    <div class="form-group">
                      <label for="gst_number">GST Number</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['gst_number'] }}" id="gst_number" name="gst_number" placeholder="Please Enter GST Number" required="">
                    </div>

                    <div class="form-group">
                      <label for="pan_number">PAN Number</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['pan_number'] }}" id="pan_number" name="pan_number" placeholder="Please Enter PAN Number" required="">
                    </div>

                    <div class="form-group">
                      <label for="address_proof">Address Proof</label>
                      <select class="form-control" name="address_proof" id="address_proof">
                        <option value="Passport" 
                        @if ($vendorDetails['address_proof'] == "Passport" ) selected @endif>
                        Passport</option>
                        
                        <option value="Voting Card"
                        @if ($vendorDetails['address_proof'] == "Voting Card" ) selected @endif>Voting Card</option>
                        <option value="PAN"
                        @if ($vendorDetails['address_proof'] == "PAN" ) selected @endif>PAN</option>
                        <option value="Driving License"
                        @if ($vendorDetails['address_proof'] == "Driving License" ) selected @endif>Driving License</option>
                        <option value="Aadhar Card"
                        @if ($vendorDetails['address_proof'] == "Aadhar Card" ) selected @endif>Aadhar Card</option>
                      </select>
                    </div>
                  
                    
                    <div class="form-group">
                      <label for="address_proof_image">Address Proof Image</label>
                      <input type="file" class="form-control" value="{{ $vendorDetails['address_proof_image'] }}" id="address_proof_image" name="address_proof_image">
                      @if(!empty($vendorDetails['address_proof_image']))
                        <a target="_blank" href="{{ url('admin/images/proofs/'.$vendorDetails['address_proof_image']) }}">  View Image </a>
                        <input type="hidden" name="current_address_proof_image" value="{{ $vendorDetails['address_proof_image'] }}">
                      @endif
                    </div>
                    
                    
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>     
            
        </div>
       @elseif ($slug == "bank")
       
        <div class="row">
          <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Update Bank Informations</h4>

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
                
                <form class="forms-sample" action="{{ url('/admin/update-vendor-details/bank') }}" method="post"
                name="updateVendorBankDetailsForm" id="updateAdminDetailsForm" enctype="multipart/form-data"> @csrf
                  <div class="form-group">
                    <label>Username / Email Address</label>
                    <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" id="email" name="email" readonly="">
                  </div>
                  
                  <div class="form-group">
                    <label for="account_holder_name">Account Holder Name</label>
                    <input type="text" class="form-control" value="{{ $vendorDetails['account_holder_name'] }}" id="account_holder_name" name="account_holder_name" placeholder="Please Enter Account Holder Name" required="">
                    
                  </div>

                  <div class="form-group">
                    <label for="bank_name">Bank Name</label>
                    <input type="text" class="form-control" value="{{ $vendorDetails['bank_name'] }}" id="bank_name" name="bank_name" placeholder="Please Enter Bank Name" required="">
                    
                  </div>

                  <div class="form-group">
                    <label for="account_number">Account Number</label>
                    <input type="text" class="form-control" value="{{ $vendorDetails['account_number'] }}" id="account_number" name="account_number" placeholder="Please Enter Account Number" required="">
                    
                  </div>

                  <div class="form-group">
                    <label for="bank_ifsc_code">Bank IFSC Code</label>
                    <input type="text" class="form-control" value="{{ $vendorDetails['bank_ifsc_code'] }}" id="bank_ifsc_code" name="bank_ifsc_code" placeholder="Please Enter Bank IFSC Code" required="">
                    
                  </div>
                  {{-- <div class="form-group">
                    <label for="admin_mobile">Mobile</label>
                    <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->mobile }}" id="admin_mobile" name="admin_mobile" 
                    placeholder="Enter minimum 5 digit and maximum 15 digit of mobile number" required="" maxlength="20" minlength="5">
                  </div>

                  <div class="form-group">
                    <label for="admin_image">Admin Image</label>
                    <input type="file" class="form-control" id="admin_image" name="admin_image">
                    @if(!empty(Auth::guard('admin')->user()->image))
                      <a target="_blank" href="{{ url('admin/images/photos/'.Auth::guard('admin')->user()->image) }}">  View Image </a>
                    @endif
                  </div> --}}
                  
                  
                  <button type="submit" class="btn btn-primary mr-2">Submit</button>
                  <button class="btn btn-light">Cancel</button>
                </form>
              </div>
            </div>
          </div>     
          
        </div>
       @endif
       
          
    </div>
    <!-- content-wrapper ends -->
    
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>
@endsection