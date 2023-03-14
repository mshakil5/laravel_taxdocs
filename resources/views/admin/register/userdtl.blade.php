@extends('admin.layouts.admin')

@section('content')



<main class="app-content">
    
    
    <!-- Containers-->
    <div class="tile mb-4">
      
      
      
      <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h2 class="mb-3 line-head">User Details</h2>
            </div>
        </div>
      </div>
      <div class="row">

        <div class="col-lg-6">
            <table class="table table-hover text-center">
                
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td>{{ $data->name }}</td>
                    </tr> 
                    <tr>
                        <td>Surname</td>
                        <td>{{ $data->surname }}</td>
                    </tr> 
                    <tr>
                        <td>Business Name</td>
                        <td>{{ $data->bname }}</td>
                    </tr> 
                    {{-- <tr>
                        <td>Business Address</td>
                        <td>{{ $data->baddress }}</td>
                    </tr>  --}}
                    <tr>
                        <td>Contact Number</td>
                        <td>{{ $data->phone }}</td>
                    </tr> 
                    <tr>
                        <td>House Number</td>
                        <td>{{ $data->house_number }}</td>
                    </tr> 
                    <tr>
                        <td>Street Name</td>
                        <td>{{ $data->street_name }}</td>
                    </tr> 
                    <tr>
                        <td>Town</td>
                        <td>{{ $data->town }}</td>
                    </tr> 
                    <tr>
                        <td>Post Code</td>
                        <td>{{ $data->postcode }}</td>
                    </tr> 
                    <tr>
                        <td>Accountant Firm </td>
                        @php
                            $firmname = \App\Models\User::where('id', $data->firm_id)->first();
                            $imgcount = \App\Models\Photo::where('user_id',$data->id)->count();
                            $notcalimgcount = \App\Models\Photo::where('user_id',$data->id)->where('status','0')->count();
                        @endphp
                        <td> @if (isset($firmname)) {{ $firmname->name }} @endif  </td>
                    </tr>                              
                    <tr>
                        <td>Number of uploaded image</td>
                        <td>{{$imgcount}}</td>
                    </tr>                             
                    <tr>
                        <td>Calculated image</td>
                        <td>{{$notcalimgcount}}</td>
                    </tr> 

                </tbody>
            </table>
        </div>
        {{-- <div class="col-lg-6">
          <div class="bs-component">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <span>{{ $data->name }}</span>
                </div>
              </div>
          </div>
        </div> --}}

      </div>
    </div>
    
  </main>




@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $("#alluser").addClass('active');
        $("#alluser").addClass('is-expanded');
        $("#user").addClass('active');
    });
</script>
@endsection
