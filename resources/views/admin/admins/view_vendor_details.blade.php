@extends('admin.layout.layout')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">VENDOR DETAILS</h3>
                        <h6 class="font-weight-normal mb-0"> <a href="{{ url('admin/admins/vendor') }}">Back to Vendor</a></h6>
                        
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

       
       <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Personal Informations</h4>

                  

                 

                  
                  
                    <div class="form-group">
                      <label>Email</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly="" >
                    </div>

                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly="">
                      
                    </div>
                    
                    <div class="form-group">
                      <label for="address">Address</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly="">
                      
                    </div>

                    <div class="form-group">
                      <label for="city">City</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly="">
                      
                    </div>

                    <div class="form-group">
                      <label for="state">State</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly="">
                      
                    </div>

                    <div class="form-group">
                      <label for="country">Country</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly="">
                      
                    </div>

                    

                    <div class="form-group">
                      <label for="pincode">Pincode</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly="">
                      
                    </div>

                    
                    <div class="form-group">
                      <label for="admin_mobile">Mobile</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly="">
                    </div>
                    @if(!empty($vendorDetails['image']))
                    <div class="form-group">
                      <label for="vendor_image">Photo</label>
                      <br>
                      <img style="width:200px" src="{{ url('admin/images/photos/'.$vendorDetails['image']) }}"/>
                        
                    </div>
                    @endif
                </div>
              </div>
            </div> 
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Business Informations</h4> 
                 
                    <div class="form-group">
                      <label>Shop Name</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_business']['shop_name'] }}" readonly="" >
                    </div>

                    <div class="form-group">
                      <label>Shop Address</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_business']['shop_address'] }}" readonly="" >
                    </div>

                    <div class="form-group">
                      <label>Shop City</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_business']['shop_city'] }}" readonly="" >
                    </div>

                    <div class="form-group">
                      <label>Shop State</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_business']['shop_state'] }}" readonly="" >
                    </div>

                    <div class="form-group">
                      <label>Shop Country</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_business']['shop_country'] }}" readonly="" >
                    </div>

                    <div class="form-group">
                      <label>Shop Pincode</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_business']['shop_pincode'] }}" readonly="" >
                    </div>

                    <div class="form-group">
                      <label>Shop Website</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_business']['shop_website'] }}" readonly="" >
                    </div>

                    <div class="form-group">
                      <label>Shop Email</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_business']['shop_email'] }}" readonly="" >
                    </div>

                    <div class="form-group">
                      <label>Address Proof</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_business']['address_proof'] }}" readonly="" >
                    </div>

                    @if(!empty($vendorDetails['vendor_business']['address_proof_image']))
                    <div class="form-group">
                      <label for="vendor_image">Address Proof Image</label>
                      <br>
                      <img style="width:200px" src="{{ url('admin/images/proofs/'.$vendorDetails['vendor_business']['address_proof_image']) }}"/>
                        
                    </div>
                    @endif

                    <div class="form-group">
                      <label>Business License Number</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_business']['business_license_number'] }}" readonly="" >
                    </div>

                    <div class="form-group">
                      <label>GST Number</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_business']['gst_number'] }}" readonly="" >
                    </div>

                    <div class="form-group">
                      <label>PAN Number</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_business']['pan_number'] }}" readonly="" >
                    </div>
                </div>
              </div>
            </div> 
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Personal Informations</h4>
                 
                    <div class="form-group">
                      <label>Account Holder Name</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_bank']['account_holder_name'] }}" readonly="" >
                    </div>

                    <div class="form-group">
                      <label>Bank Name</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_bank']['bank_name'] }}" readonly="" >
                    </div>

                    <div class="form-group">
                      <label>Account Number</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_bank']['account_number'] }}" readonly="" >
                    </div>

                    <div class="form-group">
                      <label>Bank IFSC Code</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_bank']['bank_ifsc_code'] }}" readonly="" >
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