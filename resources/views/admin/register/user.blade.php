@extends('admin.layouts.admin')
<style>
    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }
    th, td {
        text-align: left;
        padding: 8px;
    }
    tr:nth-child(even){background-color: #f2f2f2}
</style>


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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>New Client Registration</h3>
                        </div>
                        <div class="ermsg"> </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6">
                                    
                                    {!! Form::open(['url' => 'admin/register/admincreate','id'=>'createThisForm']) !!}
                                    {!! Form::hidden('registerid','', ['id' => 'registerid']) !!}
                                    @if (Auth::user()->is_type == 1)
                                        <div>
                                            <label for="firm_id">Accountant Firm</label>
                                            <select  id="firm_id" name="firm_id" class="form-control">
                                                <option value="">Select</option>
                                                @foreach (\App\Models\User::where('is_type','2')->get() as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @else
                                        <div style="display: none">
                                            <label for="firm_id">Accountant Firm</label>
                                            <input type="text" id="firm_id" name="firm_id" value="{{Auth::user()->id}}" class="form-control">
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label for="clientid">Client ID</label>
                                        <input type="text" id="clientid" name="clientid" class="form-control">
                                        <input type="hidden" id="assign" name="assign" value="1" class="form-control">
                                    </div>
                                </div>


                                <div class="col-md-3">

                                        <div>
                                            <label for="name">Name</label>
                                            <input type="text" id="name" name="name" class="form-control">
                                        </div>
                                        <div>
                                            <label for="house_number">House Number</label>
                                            <input type="text" id="house_number" name="house_number" class="form-control">
                                        </div>
                                        <div>
                                            <label for="bname">Business Name</label>
                                            <input type="text" id="bname" name="bname" class="form-control">
                                        </div>
                                        <div style="display: none">
                                            <label for="town"> Subscription Plan</label>
                                            <select name="sub_plan" id="sub_plan" class="form-control" required>
                                                <option value="">Subscription plan</option>
                                                <option value="1">Individual Plan £5.95</option>
                                                <option value="2">Business Plan £10.95</option>
                                                <option value="3">Premier Business Plan</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="password">Password</label>
                                            <input type="password" id="password" name="password" class="form-control">
                                        </div>


                                </div>

                                <div class="col-md-3">
                                    
                                        <div>
                                            <label for="surname">Surname</label>
                                            <input type="text" id="surname" name="surname" class="form-control">
                                        </div>
    
                                        <div style="display:none">
                                            <label for="baddress">Business Address</label>
                                            <input type="text" id="baddress" name="baddress" class="form-control">
                                        </div>
                                        
                                        <div>
                                            <label for="street_name">Street Name</label>
                                            <input type="text" id="street_name" name="street_name" class="form-control">
                                        </div>
    
                                        <div style="display: none">
                                            <label for="contact_person">Contact Person</label>
                                            <input type="text" id="contact_person" name="contact_person" class="form-control">
                                        </div>
                                        
                                        <div style="display: none">
                                            <label for="blandnumber">Business Land Number</label>
                                            <input type="text" id="blandnumber" name="blandnumber" class="form-control">
                                        </div>

                                        <div>
                                            <label for="bank_name">Account Name</label>
                                            <input type="text" id="bank_name" name="bank_name" class="form-control">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="cpwd">Confirm Password:</label>
                                            <input id="cpassword" type="password" class="form-control" name="cpassword" required autocomplete="new-password">
                                        </div>
                                        
                                        
                                        
                                        
                                </div>

                                <div class="col-md-3">
                                    
                                    <div>
                                        <label for="email">Email</label>
                                        <input type="email" id="useremail" name="useremail" class="form-control">
                                    </div>
                                    <div>
                                        <label for="town"> Town</label>
                                        <input type="text" id="town" name="town" class="form-control">
                                    </div>
                                    

                                    <div>
                                        <label for="bank_account_number"> Account Number</label>
                                        <input type="text" id="bank_account_number" name="bank_account_number" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-3">

                                    <div>
                                        <label for="phone">Mobile</label>
                                        <input type="text" id="phone" name="phone" class="form-control">
                                    </div>
                                    
                                    <div>
                                        <label for="postcode">Post Code</label>
                                        <input type="text" id="postcode" name="postcode" class="form-control">
                                    </div>


                                    <div>
                                        <label for="bank_account_code"> Account Sort Code</label>
                                        <input type="text" id="bank_account_code" name="bank_account_code" class="form-control">
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
            </div>

        </div>

        <button id="newBtn" type="button" class="btn btn-info">Add New</button>
        <hr>

        <div id="contentContainer">


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3> Client Account Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="container" style="max-width: 1200px;">
                                    <table class="table table-bordered table-hover table-responsive" id="example" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Date</th>
                                            <th>Client ID</th>
                                            <th>Business Name</th>
                                            <th>Number of Document</th>
                                            <th>Document Processed</th>
                                            <th>Report</th>
                                            <th>Image</th>
                                            <th>Paid Invoice</th>
                                            <th>Payroll</th>
                                            <th>Status</th>
                                            <th>Details</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($accounts as $key => $account)
                                            @php
                                                $firmname = \App\Models\User::where('id',$account->firm_id)->first();
                                                $imgcount = \App\Models\Photo::where('user_id',$account->id)->count();
                                                $notcalimgcount = \App\Models\Photo::where('user_id',$account->id)->where('status','1')->count();
                                            @endphp
                                                <tr>
                                                    <td>{{$key++}}</td>
                                                    <td>{{$account->created_at->format("d/m/Y")}}</td>
                                                    <td>{{$account->clientid}}</td>
                                                    <td>{{$account->bname}}</td>
                                                    <td>{{$imgcount}}</td>
                                                    <td>{{$notcalimgcount}}</td>
                                                    <td>
                                                        <a class="btn btn-success btn-sm text-white" href="{{route('admin.report',encrypt($account->id))}}"> Report</a>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm text-white" href="{{ route('showimg', encrypt($account->id) )}}">Image</a>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-dark btn-sm text-white" href="{{ route('admin.paidinvoice', encrypt($account->id) )}}">
                                                        Invoice</a>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-secondary btn-sm text-white" href="{{ route('payroll', encrypt($account->id) )}}">Payroll</a>
                                                    </td>
                                                    
                                                    <td>
                                                        <div class="toggle-flip">
                                                            <label>
                                                                <input type="checkbox" class="toggle-class" data-id="{{$account->id}}" {{ $account->status ? 'checked' : '' }}><span class="flip-indecator" data-toggle-on="Active" data-toggle-off="Inactive"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm text-white" href="{{route('show.userdtl',encrypt($account->id))}}"> View</a>
                                                    </td>
                                                    <td class="text-center">
                                                        
                                                        
                                                        
                                                        
                                                        <a id="EditBtn" class="btn btn-warning btn-sm text-white"  rid="{{$account->id}}">Edit</a>
                                                        {{-- <a id="deleteBtn" rid="{{$account->id}}"><i class="fa fa-trash-o" style="color: red;font-size:16px;"></i></a> --}}
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

        </div>


    </main>

@endsection
@section('script')
<script>
$(document).ready(function() {
    var table = $('#example').DataTable( {
        responsive: true,
        lengthChange: false,
        buttons: ['excel', 'pdf', 'colvis' ]
    } );

    
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
});

// $(document).ready(function() {
//     var table = $('#example').DataTable( {
//         responsive: true
//     } );
 
//     new $.fn.dataTable.FixedHeader( table );
// } );


</script>

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
                // window.setTimeout(function(){location.reload()},2000)
                $("#addThisFormContainer").hide(200);
                $("#newBtn").show(100);
                clearform();
            });


            //header for csrf-token is must in laravel
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            //

            var url = "{{URL::to('/admin/user-register')}}";
            // console.log(url);
            $("#addBtn").click(function(){
                //alert('form work');
                if($(this).val() == 'Create') {

                    $.ajax({
                        url: url,
                        method: "POST",
                        data: {
                            name: $("#name").val(),
                            surname: $("#surname").val(),
                            email: $("#useremail").val(),
                            bname: $("#bname").val(),
                            house_number: $("#house_number").val(),
                            baddress: $("#baddress").val(),
                            contact_person: $("#contact_person").val(),
                            blandnumber: $("#blandnumber").val(),
                            phone: $("#phone").val(),
                            postcode: $("#postcode").val(),
                            street_name: $("#street_name").val(),
                            town: $("#town").val(),
                            subscription_plan: $("#sub_plan").val(),
                            firm_id: $("#firm_id").val(),
                            bank_acc_number: $("#bank_account_number").val(),
                            bank_acc_sort_code: $("#bank_account_code").val(),
                            bank_name: $("#bank_name").val(),
                            clientid: $("#clientid").val(),
                            assign: $("#assign").val(),
                            password: $("#password").val(),
                            cpassword: $("#cpassword").val()
                        },
                        success: function (d) {
                            if (d.status == 303) {
                                pagetop();
                                $(".ermsg").html(d.message);
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
                }

                //create  end
                //Update
                if($(this).val() == 'Update'){

                    $.ajax({
                        url:url+'/'+$("#registerid").val(),
                        method: "PUT",
                        type: "PUT",
                        data:{ 
                            registerid: $("#registerid").val(),
                            name: $("#name").val(),
                            surname: $("#surname").val(),
                            email: $("#useremail").val(),
                            bname: $("#bname").val(),
                            house_number: $("#house_number").val(),
                            baddress: $("#baddress").val(),
                            contact_person: $("#contact_person").val(),
                            blandnumber: $("#blandnumber").val(),
                            phone: $("#phone").val(),
                            postcode: $("#postcode").val(),
                            street_name: $("#street_name").val(),
                            town: $("#town").val(),
                            subscription_plan: $("#sub_plan").val(),
                            firm_id: $("#firm_id").val(),
                            bank_acc_number: $("#bank_account_number").val(),
                            bank_acc_sort_code: $("#bank_account_code").val(),
                            bank_name: $("#bank_name").val(),
                            clientid: $("#clientid").val(),
                            password: $("#password").val(),
                            cpassword: $("#cpassword").val()
                            },
                        success: function(d){
                            if (d.status == 303) {
                                pagetop();
                                $(".ermsg").html(d.message);
                            }else if(d.status == 300){
                                success("User Updated Successfully!!");
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
                $accountid = $(this).attr('rid');
                $info_url = url + '/'+$accountid+'/edit';
                $.get($info_url,{},function(d){
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
                $("#surname").val(data.surname);
                $("#useremail").val(data.email);
                $("#phone").val(data.phone);   
                $("#bname").val(data.bname);   
                $("#firm_id").val(data.firm_id);   
                $("#baddress").val(data.baddress);   
                $("#contact_person").val(data.contact_person);   
                $("#blandnumber").val(data.blandnumber);   
                $("#house_number").val(data.house_number);   
                $("#town").val(data.town);   
                $("#bank_account_number").val(data.bank_acc_number);   
                $("#sub_plan").val(data.subscription_plan);   
                $("#bank_account_code").val(data.bank_acc_sort_code);  
                $("#bank_name").val(data.bank_name); 
                $("#clientid").val(data.clientid);   
                $("#surname").val(data.surname);   
                $("#blandnumber").val(data.blandnumber);   
                $("#contact_person").val(data.contact_person);   
                $("#postcode").val(data.postcode);   
                $("#street_name").val(data.street_name);   
                $("#surname").val(data.surname);     
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
    <script type="text/javascript">
        $(document).ready(function() {
            $("#alluser").addClass('active');
            $("#alluser").addClass('is-expanded');
            $("#user").addClass('active');
        });
    </script>

@endsection
