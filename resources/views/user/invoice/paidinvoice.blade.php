@extends('layouts.user')
@section('content')
<style>
    .pl25{
        padding-left: 25px;
    }
</style>

<div class="dashboard-content">


    <section class=""> 
        <div class="row  my-3 mx-0 "> 
            <div class="col-md-12">
                <div class="row my-2">
                            
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
                                        <th style="text-align: center">Message</th>
                                        <th style="text-align: center">Total</th>
                                        <th style="text-align: center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($data as $key =>  $data)
                                    <tr>
                                      <td style="text-align: center">{{ $key + 1 }}</td>
                                      <td style="text-align: center">{{ $data->invoice_date }}</td>
                                      <td style="text-align: center">{{ $data->invoiceid }}</td>
                                      <td style="text-align: center">{{ \App\Models\NewUser::where('id',$data->new_user_id)->first()->name }}</td>
                                      <td style="text-align: center">{{ $data->email }}</td>
                                      <td style="text-align: center">{{ $data->billing_address }}</td>
                                      <td style="text-align: center">{{ $data->message_on_invoice }}</td>
                                      <td style="text-align: center">{{ $data->total }}</td>
                                      <td style="text-align: center">

                                        
                                        <a class="text-decoration-none bg-success text-white py-1 px-3 rounded mb-1 d-block text-center" href="{{ route('user.invoicesendemail',$data->id)}}" target="blank">
                                         <small>Send Email</small> </a>
                                         
                                        <div class="py-1 text-center">
                                        <a href="{{ route('user.invoicedtl',$data->id)}}"><i class="fa fa-eye" style="color: #09a311;font-size:16px;"></i></a>
                                        {{-- <a href="{{ route('user.invoiceedit',$data->id)}}"><i class="fa fa-edit" style="color: #2094f3;font-size:16px;"></i></a>
                                        <a id="deleteBtn" rid="{{$data->id}}"><i class="fa fa-trash-o" style="color: red;font-size:16px;"></i></a> --}}
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