<?php

//echo"<pre>"; print_r($banners);die;
?>

@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">     
            
            
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3 class="font-weight-bold">BANNERS MANAGEMENT</h3>
                  <h4 class="card-title">Banners</h4>
                  {{-- <p class="card-description">
                    Add class <code>.table-bordered</code>
                  </p> --}}
                  <a 
                  style="max-width:150px; float: right; display:inline-block"
                  href="{{ url('admin/add-edit-banner')}}" class="btn btn-block btn-primary"> Add Banner</a>

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
                    <table id="banners" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            ID
                          </th>
                          <th>
                            Image
                          </th>

                          <th>
                            Link
                          </th>

                          <th>
                            Title
                          </th> 
                          
                          <th>
                            Alt
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
                        @foreach ($banners as $banner)                       
                        
                        <tr>
                          <td>
                            {{ $banner['id'] }}
                          </td>
                          <td>
                             <img style="width:150px;" src={{ asset('front/images/banner_images/'.$banner['image']) }} />
                          </td>

                          <td>
                            {{ $banner['link'] }}
                          </td>

                          <td>
                            {{ $banner['title'] }}
                          </td>

                          <td>
                            {{ $banner['alt'] }}
                          </td>                         
                          

                          <td>
                            @if($banner['status'] == 1)

                              <a class="updateBannerStatus" id="banner-{{ $banner['id'] }}" banner_id ="{{ $banner['id'] }}" href="javascript:void(0)">
                                <i style="font-size:25px" class="mdi mdi-bookmark-check" status="Active"> </i>
                              </a>
                            @else
                              <a class="updateBannerStatus" id="banner-{{ $banner['id'] }}" banner_id ="{{ $banner['id'] }}" href="javascript:void(0)">
                                <i style="font-size:25px" class="mdi mdi-bookmark-outline" status="InActive"> </i>
                              </a>
                            @endif
                            
                          </td>
                          
                                             
                          <td>
                           
                              <a href="{{ url('admin/add-edit-banner/'.$banner['id']) }}">
                                <i style="font-size:25px" class="mdi mdi-pencil-box"> </i>
                              </a>

                              {{-- <a title="Section" class="confirmDelete" href="{{ url('admin/delete-section/'.$section['id']) }}">
                                <i style="font-size:25px" class="mdi mdi-file-excel-box"> </i>
                              </a> --}}
                              <a href="javascript:void(0)" class="confirmDelete" module="banner" moduleid="{{ $banner['id'] }}">
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