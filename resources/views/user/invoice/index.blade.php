@extends('layouts.user')
@section('content')
<style>
    .pl25{
        padding-left: 25px;
    }
    
    /*loader css*/
    #loading {
    position: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    opacity: 0.7;
    background-color: #fff;
    z-index: 99;
    }

    #loading-image {
    z-index: 100;
    }

</style>

<div class="dashboard-content">

    <!-- Image loader -->
    <div id='loading' style='display:none ;'>
        <img src="{{ asset('images/company/loader.gif') }}" id="loading-image" alt="Loading..." style="height: 225px;" />
   </div>
 <!-- Image loader -->

       <section class=""> 
        <div class="row  my-3 mx-0 "> 
            <div class="col-md-12">
                <div class="row my-2">
                            <div class="ermsg"></div>
                    <div class="col-md-12 mt-2 text-center">
                        <div class="overflow">
                            <table class="table table-custom shadow-sm bg-white contentContainer" id="example">
                                <thead>
                                    <tr> 
                                        <th style="text-align: center">Sl</th>
                                        <th style="text-align: center">Date</th>
                                        <th style="text-align: center">Invoice No</th>
                                        <th style="text-align: center">Name</th>
                                        <th style="text-align: center">Email</th>
                                        <th style="text-align: center">Billing Address</th>
                                        <th style="text-align: center">Total</th>
                                        <th style="text-align: center">Email</th>
                                        <th style="text-align: center;width:20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($data as $key =>  $data)
                                    <tr>
                                      <td style="text-align: center">{{ $key + 1 }}</td>
                                      <td style="text-align: center;width: 125px">{{ $data->invoice_date }}</td>
                                      <td style="text-align: center">
                                        <a href="{{ route('user.invoiceedit',$data->id)}}" class="text-decoration-none bg-primary text-white py-1 px-3 rounded mb-1 text-center">{{ substr($data->invoiceid, -6) }}</a>
                                        </td>
                                      <td style="text-align: center;width: 180px">{{ \App\Models\NewUser::where('id',$data->new_user_id)->first()->name }}</td>
                                      <td style="text-align: center">{{ $data->email }}</td>
                                      <td style="text-align: center">{{ $data->billing_address }}</td>
                                      <td style="text-align: center">{{ $data->total }}</td>
                                      <td style="text-align: center">
                                        {{-- <button class="text-decoration-none bg-success text-white py-1 px-3 rounded mb-1 d-block text-center invoice-send-mail"  data-id="{{$data->id}}"> <small>Send Email</small> </button> --}}
                                      </td>
                                      <td style="text-align: center">

                                        <button class="text-decoration-none bg-info text-white py-1 px-3 rounded mb-1 text-center invoice-paid-status" data-id="{{$data->id}}"> Paid </button>
                                        @if ($data->status == 0)
                                        <a id="deleteBtn" rid="{{$data->id}}"><i class="fa fa-trash-o mt-1" style="color: red;font-size:24px;"></i></a>
                                        @endif

                                        <div class="py-1 text-center" style="width: 100px">
                                        <a href="{{ route('invoice.download',$data->id)}}"  class="text-decoration-none bg-secondary text-white py-1 px-3 rounded mb-1 text-center">Download </a>
                                        
                                        
                                        {{-- <a href="{{ route('user.invoiceedit',$data->id)}}" class="text-decoration-none bg-primary text-white py-1 px-3 rounded mb-1 text-center">Edit</a> --}}

                                        
                                        </div>
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
    </section> 

</div>




@endsection
@section('script')
<script>
    $(function() {
      $('.invoice-paid-status').click(function() {
        $("#loading").show();
        var activeurl = "{{URL::to('/user/invoice-paid-status')}}";
          var id = $(this).data('id');
          $.ajax({
              type: "GET",
              dataType: "json",
              url: activeurl,
              data: {'id': id},
              success: function(d){
                // console.log(data.success)
                if (d.status == 303) {
                            $(".ermsg").html(d.message);
                    }else if(d.status == 300){
                            $(".ermsg").html(d.message);
                        window.setTimeout(function(){location.reload()},2000)
                    }
                },
                complete:function(d){
                        $("#loading").hide();
                    },
                error: function (d) {
                    console.log(d);
                }
          });
      })
    })
</script>

<script>
    $(document).ready(function () {

     //header for csrf-token is must in laravel
     $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        //

      $('.invoice-send-mail').click(function() {
        $("#loading").show();
        var activeurl = "{{URL::to('/user/invoice-sent-email')}}";
          var id = $(this).data('id');
          $.ajax({
              url: activeurl,
              method: "POST",
              data: {'id': id},
              success: function(d){
                if (d.status == 303) {
                            $(".ermsg").html(d.message);
                    }else if(d.status == 300){
                            $(".ermsg").html(d.message);
                        window.setTimeout(function(){location.reload()},2000)
                    }
                },
                complete:function(d){
                        $("#loading").hide();
                    },
                error: function (d) {
                    console.log(d);
                }
          });
      })
    });
</script>

<script>

    $(document).ready(function () {
        $('#example').DataTable();
    });

    var url = "{{URL::to('/user/invoice-delete')}}";
    //Delete
    $(".contentContainer").on('click','#deleteBtn', function(){
                if(!confirm('Sure?')) return;
                codeid = $(this).attr('rid');
                info_url = url + '/'+codeid;
                $.ajax({
                    url:info_url,
                    method: "GET",
                    type: "DELETE",
                    data:{
                    },
                    success: function(d){
                        if(d.success) {
                            alert(d.message);
                            location.reload();
                        }
                    },
                    error:function(d){
                        console.log(d);
                    }
                });
            });
            //Delete

</script>

@endsection
