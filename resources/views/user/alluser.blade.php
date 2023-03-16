@extends('layouts.user')
@section('content')
<style>
    .pl25{
        padding-left: 25px;
    }
</style>

<div class="dashboard-content">
    <section class="profile purchase-status px-4" id="addThisFormContainer">
        <div class="title-section row mt-3">
            <div class="col-md-12">
                <div class="ermsg"></div>
                <div class="col-md-12 text-muted bg-white ">
                        <div class="row mb-3">
                            <div class="col-md-6 ">
                                <label> Name<span style="color: red">*</span></label>
                                <input type="text" placeholder="Name" id="name" name="name"  class="form-control" >
                                <input type="hidden" id="uid" name="uid" >
                            </div>
                            
                            <div class="col-md-6 ">
                                <label> Email<span style="color: red">*</span></label>
                                <input type="email" id="email" name="email" class="form-control" >
                            </div>

                            <div class="col-md-12 ">
                                <label> Address <span style="color: red">*</span></label>
                                <input type="text" placeholder="Address" id="address" name="address" class="form-control" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 my-2">
                                <button class="text-white btn-theme ml-1" id="adduserBtn" type="submit"> Submit </button>
                                <button class="text-white btn btn-warning ml-1" id="FormCloseBtn"> Close </button>
                            </div>
                        </div>
                </div>
            </div>
        </div>

    </section>

    <button class="text-white btn-theme ml-1 mt-4" id="newBtn"> Add New </button>

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
                                        <th style="text-align: center">Name</th>
                                        <th style="text-align: center;width:50%">Email</th>
                                        <th style="text-align: center">Address </th> 
                                        <th style="text-align: center">Action </th> 
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($data as $key => $data)
                                    <tr>
                                      <td style="text-align: center">{{ $key + 1 }}</td>
                                      <td style="text-align: center">{{ $data->name }}</td>
                                      <td style="text-align: center;width:50%">
                                        {{ $data->email }}
                                      </td>
                                      <td style="text-align: center">
                                        {{ $data->address }}
                                      </td>
                                      <td style="text-align: center">
                                        <div class="py-1 text-center">
                                            
                                            <a id="editBtn" class="editBtn" uid="{{$data->id}}" uname="{{$data->name}}" uemail="{{ $data->email }}" uaddress="{{$data->address}}"><i class="fa fa-edit" style="color: #2094f3;font-size:16px;"></i></a>
                                            <a id="deleteBtn" rid="{{$data->id}}"><i class="fa fa-trash-o" style="color: red;font-size:16px;"></i></a>
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
        $("#addThisFormContainer").hide();
        $("#newBtn").click(function(){
            $("#newBtn").hide(100);
            $("#addThisFormContainer").show(300);

        });
        $("#FormCloseBtn").click(function(){
            $("#addThisFormContainer").hide(200);
            $("#newBtn").show(100);
        });
        //header for csrf-token is must in laravel
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        //
        var url = "{{URL::to('/user/new-user')}}";
        // console.log(url);

            $("body").delegate("#adduserBtn","click",function(event){
                event.preventDefault();

                var name = $("#name").val();
                var email = $("#email").val();
                var address = $("#address").val();
                

                $.ajax({
                    url: url,
                    method: "POST",
                    data: {name,email,address},

                    success: function (d) {
                        if (d.status == 303) {
                            $(".ermsg").html(d.message);
                            pagetop();
                        }else if(d.status == 300){
                            $(".ermsg").html(d.message);
                            pagetop();
                            window.setTimeout(function(){location.reload()},2000)
                            
                        }
                    },
                    error: function (d) {
                        console.log(d);
                    }
                });

            });

         
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


            $(document).on('click', '.editBtn', function () {
                let phistryid = $(this).val();
                uid = $(this).attr('uid');
                uname = $(this).attr('uname');
                uemail = $(this).attr('uemail');
                uaddress = $(this).attr('uaddress');
                
                $("#addThisFormContainer").show(300);  
                pagetop();



                
            });
        
        

    });

    $(document).ready(function () {
        $('#example').DataTable();
    });

    

</script>

@endsection
