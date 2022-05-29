@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">     
            
            
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3 class="font-weight-bold">CATALOGUE MANAGEMENT</h3>
                  <h4 class="card-title">Brands</h4>
                  {{-- <p class="card-description">
                    Add class <code>.table-bordered</code>
                  </p> --}}
                  <a 
                  style="max-width:150px; float: right; display:inline-block"
                  href="{{ url('admin/add-edit-brand')}}" class="btn btn-block btn-primary"> Add Brand</a>

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
                    <table id="brands" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            ID
                          </th>
                          <th>
                            Name
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
                        @foreach ($brands as $brand)
                          
                        
                        <tr>
                          <td>
                            {{ $brand['id'] }}
                          </td>
                          <td>
                            {{ $brand['name'] }}
                          </td>

                          <td>
                            @if($brand['status'] == 1)

                              <a class="updateBrandStatus" id="brand-{{ $brand['id'] }}" brand_id ="{{ $brand['id'] }}" href="javascript:void(0)">
                                <i style="font-size:25px" class="mdi mdi-bookmark-check" status="Active"> </i>
                              </a>
                            @else
                              <a class="updateBrandStatus" id="brand-{{ $brand['id'] }}" brand_id ="{{ $brand['id'] }}" href="javascript:void(0)">
                                <i style="font-size:25px" class="mdi mdi-bookmark-outline" status="InActive"> </i>
                              </a>
                            @endif
                            
                          </td>
                          
                                             
                          <td>
                           
                              <a href="{{ url('admin/add-edit-brand/'.$brand['id']) }}">
                                <i style="font-size:25px" class="mdi mdi-pencil-box"> </i>
                              </a>

                              {{-- <a title="Brand" class="confirmDelete" href="{{ url('admin/delete-brand/'.$brand['id']) }}">
                                <i style="font-size:25px" class="mdi mdi-file-excel-box"> </i>
                              </a> --}}
                              <a href="javascript:void(0)" class="confirmDelete" module="brand" moduleid="{{ $brand['id'] }}">
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