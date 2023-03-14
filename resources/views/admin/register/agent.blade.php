@extends('admin.layouts.admin')



@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            </ul>
        </div>
        <div id="addThisFormContainer">

            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3>New Register</h3>
                        </div>
                        <div class="ermsg"></div>
                        <div class="card-body">
                            
                            


                            <div class="row">

                                <div class="col-md-6">
                                    <div class="container">

                                        {!! Form::open(['url' => 'admin/register/admincreate','id'=>'createThisForm']) !!}
                                    {!! Form::hidden('registerid','', ['id' => 'registerid']) !!}

                                    
                                    <div>
                                        <label for="name">Name</label>
                                        <input type="text" id="name" name="name" class="form-control">
                                    </div>
                                    <div>
                                        <label for="house_number">House</label>
                                        <input type="text" id="house_number" name="house_number" class="form-control">
                                    </div>
                                    <div>
                                        <label for="agent_street_name">Street Name</label>
                                        <input type="text" id="agent_street_name" name="agent_street_name" class="form-control">
                                    </div>
                                    <div>
                                        <label for="phone">Contact Number</label>
                                        <input type="text" id="phone" name="phone" class="form-control">
                                    </div>

                                    <div>
                                        <label for="password">Password</label>
                                        <input type="password" id="password" name="password" class="form-control">
                                    </div>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="container">
                                        
                                    <div>
                                        <label for="email">Email</label>
                                        <input type="email" id="accemail" name="email" class="form-control">
                                    </div>
                                        
                                        
                                    <div>
                                        <label for="town">Town</label>
                                        <input type="text" id="town" name="town" class="form-control">
                                    </div>
                                    <div>
                                        <label for="postcode">Post Code</label>
                                        <input type="text" id="postcode" name="postcode" class="form-control">
                                    </div>

                                        
                                    <div>
                                        <label for="contact_person">Contact Person</label>
                                        <input type="text" id="contact_person" name="contact_person" class="form-control">
                                    </div>
    
                                    <div class="form-group">
                                        <label for="cpwd">Confirm Password:</label>
                                        <input id="cpassword" type="password" class="form-control" name="cpassword" required autocomplete="new-password">
                                    </div>
    

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <hr>
                                    <input type="button" id="addBtn" value="Create" class="btn btn-primary">
                                    <input type="button" id="FormCloseBtn" value="Close" class="btn btn-warning">
                                    {!! Form::close() !!}
                                </div>

                            </div>

                            



                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                </div>
            </div>

        </div>
        <button id="newBtn" type="button" class="btn btn-info">Add New</button>
        <hr>

        <div id="contentContainer">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3> Accuntancy Firm Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover" id="example">
                                        <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Contact Number</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $n = 1;
                                            ?>
                                            @forelse ($accounts as $account)
                                                <tr>
                                                <td>{{$n++}}</td>
                                                <td>{{$account->created_at->format("m/d/Y")}}</td>
                                                <td>{{$account->name}}</td>
                                                <td>{{$account->email}}</td>
                                                <td>{{$account->phone}}</td>
                                                <td>
                                                    <div class="toggle-flip">
                                                        <label>
                                                            <input type="checkbox" class="toggle-class" data-id="{{$account->id}}" {{ $account->status ? 'checked' : '' }}><span class="flip-indecator" data-toggle-on="Active" data-toggle-off="Inactive"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                </td>
                                                    <td>
                                                        <a href="{{ route('allcustomer',$account->id)}}" ><i class="fa fa-eye" style="color: #23b64f;font-size:16px;"></i></a>
                                                        <a id="EditBtn" rid="{{$account->id}}"><i class="fa fa-edit" style="color: #2196f3;font-size:16px;"></i></a>
                                                        <a id="deleteBtn" rid="{{$account->id}}"><i class="fa fa-trash-o" style="color: red;font-size:16px;"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <h3>No post found from you. Create a new Account</h3>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
@section('script')
<script>
    $(function() {
      $('.toggle-class').change(function() {
        var url = "{{URL::to('/active-user')}}";
          var status = $(this).prop('checked') == true ? 1 : 0;
          var id = $(this).data('id');
           console.log(status);
          $.ajax({
              type: "GET",
              dataType: "json",
              url: url,
              data: {'status': status, 'id': id},
              success: function(d){
                // console.log(data.success)
                if (d.status == 303) {
                        warning("Deactive Successfully!!");
                    }else if(d.status == 300){
                        success("Active Successfully!!");
                        // window.setTimeout(function(){location.reload()},2000)
                    }
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

            $("#addThisFormContainer").hide();
            $("#newBtn").click(function(){
                clearform();
                $("#newBtn").hide(100);
                $("#addThisFormContainer").show(300);
            });
            $("#FormCloseBtn").click(function(){
                $("#addThisFormContainer").hide(200);
                $("#newBtn").show(100);
                clearform();
            });


            //header for csrf-token is must in laravel
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            //

            var url = "{{URL::to('/admin/agent-register')}}";
            // console.log(url);

            $("#addBtn").click(function(){
            //   alert("#addBtn");
                if($(this).val() == 'Create') {
                     
                    var form_data = new FormData();
                    form_data.append("name", $("#name").val());
                    form_data.append("email", $("#accemail").val());
                    form_data.append("phone", $("#phone").val());

                    form_data.append("house_number", $("#house_number").val());
                    form_data.append("street_name", $("#agent_street_name").val());
                    form_data.append("town", $("#town").val());
                    form_data.append("postcode", $("#postcode").val());
                    form_data.append("contact_person", $("#contact_person").val());

                    form_data.append("password", $("#password").val());
                    form_data.append("cpassword", $("#cpassword").val());

                    $.ajax({
                      url: url,
                      method: "POST",
                      contentType: false,
                      processData: false,
                      data:form_data,
                      success: function (d) {
                          if (d.status == 303) {
                              $(".ermsg").html(d.message);
                          }else if(d.status == 300){
                            success("Data Insert Successfully!!");
                                window.setTimeout(function(){location.reload()},2000)
                          }
                      },
                      error: function (d) {
                          console.log(d);
                      }
                  });
                }
                //create  end
                //Update
                if($(this).val() == 'Update'){

                  var form_data = new FormData();
                  form_data.append("name", $("#name").val());
                  form_data.append("email", $("#accemail").val());
                  form_data.append("phone", $("#phone").val());
                  form_data.append("house_number", $("#house_number").val());
                  form_data.append("street_name", $("#agent_street_name").val());
                  form_data.append("town", $("#town").val());
                  form_data.append("postcode", $("#postcode").val());
                  form_data.append("contact_person", $("#contact_person").val());
                  form_data.append("password", $("#password").val());
                  form_data.append("cpassword", $("#cpassword").val());
                  form_data.append("uid", $("#registerid").val());
                  form_data.append('_method', 'put');
                    $.ajax({
                        url:url+'/'+$("#registerid").val(),
                        type: "POST",
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        data:form_data,
                        success: function(d){
                            console.log(d);
                            if (d.status == 303) {
                                $(".ermsg").html(d.message);
                                pagetop();
                            }else if(d.status == 300){
                                success("Data Update Successfully!!");
                                window.setTimeout(function(){location.reload()},2000)
                            }
                        },
                        error:function(d){
                            console.log(d);
                        }
                    });
                }
                //Update
            });
            //Edit
            $("#contentContainer").on('click','#EditBtn', function(){
                //alert("btn work");
                codeid = $(this).attr('rid');
                //console.log($codeid);
                info_url = url + '/'+codeid+'/edit';
                //console.log($info_url);
                $.get(info_url,{},function(d){
                    populateForm(d);
                    pagetop();
                });
            });
            //Edit  end

             //Delete 
             $("#contentContainer").on('click','#deleteBtn', function(){
            var registerid = $(this).attr('rid');
            var info_url = url + '/'+registerid;
            swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel plx!",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url:info_url,
                    method: "GET",
                    type: "DELETE",
                    data:{
                    },
                    success: function(d){
                        if(d.success) {
                            swal("Deleted!", "Your imaginary file has been deleted.", "success");     
                            location.reload();
                        }
                    },
                    error:function(d){
                        console.log(d);
                    }
                });
            } else {
                swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
            });
            });
            //Delete  
            

            function populateForm(data){
                $("#name").val(data.name);
                $("#accemail").val(data.email);
                $("#phone").val(data.phone);
                $("#house_number").val(data.house_number);
                $("#town").val(data.town);
                $("#postcode").val(data.postcode);
                $("#contact_person").val(data.contact_person);
                $("#agent_street_name").val(data.street_name);
                $("#registerid").val(data.id);
                $("#addBtn").val('Update');
                $("#addThisFormContainer").show(300);
                $("#newBtn").hide(100);
            }
            function clearform(){
                $('#createThisForm')[0].reset();
                $("#addBtn").val('Create');
            }


        });

        
    </script>

<script>
$(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
    } );
    
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
</script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#alluser").addClass('active');
            $("#alluser").addClass('is-expanded');
            $("#agent").addClass('active');
        });
    </script>

@endsection
