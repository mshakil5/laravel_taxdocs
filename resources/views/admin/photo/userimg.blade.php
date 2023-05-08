@extends('admin.layouts.admin')
@section('content')
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

    .popup{
    width: 240px;
    margin: auto;
    text-align: center
    }
    .popup img{
        width: 100px;
        height: 100px;
        cursor: pointer
    }
    .show{
        z-index: 999;
    }
    .show .overlay{
        margin-top: 540px;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,.66);
        position: absolute;
        top: 0;
        left: 0;
    }
    .show .img-show{
        margin-top: 540px;
        width: 600px;
        height: 400px;
        background: #FFF;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        overflow: hidden
    }
    .img-show span{
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 99;
        cursor: pointer;
    }
    .img-show img{
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
    }
    /*End style*/
</style>

@php
    $firmID = \App\Models\User::where('id', $id)->first();
@endphp


    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> {{$user->bname}} All Documents</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            </ul>
        </div>

        <a href="{{ route('alluser')}}" id="backBtn" class="btn btn-info">Back</a>
        <button id="newBtn" type="button" class="btn btn-info">Add New</button>

        <hr>

        <div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3> Client Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="container">
                                    <table class="table table-bordered table-hover table-responsive">
                                        <thead>
                                        <tr>
                                            <th style="text-align: center; width:15%">Name</th>
                                            <th style="text-align: center; width:20%">Email</th>
                                            <th style="text-align: center; width:10%">Client ID</th>
                                            <th style="text-align: center; width:20%">Business Name</th>
                                            <th style="text-align: center; width:20%">Business Address</th>
                                            <th style="text-align: center; width:20%">Firm Name </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($user))
                                                <tr>
                                                    <td style="text-align: center">{{ $user->name }}</td>
                                                    <td style="text-align: center">{{ $user->email }}</td>
                                                    <td style="text-align: center">{{ $user->clientid }}</td>
                                                    <td style="text-align: center">{{ $user->bname }}
                                                    <input type="hidden" id="bname" value="{{$user->bname}}">
                                                    </td>
                                                    <td style="text-align: center">{{ $user->baddress }}</td>
                                                    <td style="text-align: center">{{ \App\Models\User::where('id',$user->firm_id)->first()->name}}</td>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>


        <div id="addThisFormContainer">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Accounts</h3>
                        </div>
                        <div class="ermsg"></div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-7">
                                    <div class="container">
                                        <div class="showimg">

                                        </div>
                                    </div>
                                </div>

                                

                                <div class="col-md-5">
                                    <div class="container">

                                        {!! Form::open(['url' => 'admin/register/admincreate','id'=>'createThisForm']) !!}
                                        
                                        <div>
                                            <label for="date">Date</label>
                                            <input type="date" id="date" name="date" class="form-control" value="{{date('Y-m-d')}}">
                                            <input type="hidden" id="dataid" name="dataid" class="form-control">
                                            <input type="hidden" id="uid" name="uid" class="form-control">
                                        </div>

                                        <div>
                                            <label for="particular">Particular</label>
                                            <input type="text" id="particular" name="particular" class="form-control">
                                        </div>
                                        <div>
                                            <label for="category">Category</label>
                                            <select name="category" id="category" class="form-control">
                                                <option value="">Select</option>
                                                <option value="Receivable">Receivable</option>
                                                <option value="Payable" selected>Payable</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label for="amount">Amount</label>
                                            <input type="number" id="amount" name="amount" class="form-control">
                                        </div>

                                        <div>
                                            <label for="vat">Vat Amount</label>
                                            <input type="number" id="vat" name="vat" class="form-control">
                                        </div>
                                        <div>
                                            <label for="net">Net</label>
                                            <input type="number" id="net" name="net" class="form-control" readonly>
                                        </div>

                                    </div>
                                    <hr>
                                    <input type="button" id="addImgDtlBtn" value="Create" class="btn btn-primary">
                                    <input type="button" id="FormCloseBtn" value="Close" class="btn btn-warning">
                                    {!! Form::close() !!}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="addNewFormContainer">
            <div class="row">
                <div class="col-md-2">

                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3>Add New Documents</h3>
                        </div>
                        <div class="ermsg"></div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="container">

                                        {!! Form::open(['url' => 'admin/register/admincreate','id'=>'createThisForm']) !!}
                                        <div>
                                            <label for="date">Date</label>
                                            <input type="date" id="newdate" name="date" class="form-control" value="{{date('Y-m-d')}}">
                                            <input type="hidden" id="newuid" name="newuid" class="form-control" value="{{$id}}">
                                            <input type="hidden" id="firm_id" name="firm_id" class="form-control" value="{{$firmID->firm_id}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="container">
                                        
                                        <div>
                                            <label for="image">Image</label>
                                            <input type="file" placeholder="Image" id="media" name="media[]" class="form-control" multiple="" >
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-12" style="display: none">
                                    <div class="container">
                                            <div class="preview2"></div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <hr>
                                    <input type="button" id="createNewBtn" value="Upload" class="btn btn-primary">
                                    <input type="button" id="CloseBtn" value="Close" class="btn btn-warning">
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

        
        <hr>
        <div id="contentContainer">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3> All Documents</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover table-responsive" id="example">
                                <thead>
                                <tr>
                                    <th style="text-align: center">ID</th>
                                    <th style="text-align: center">Date</th>
                                    <th style="text-align: center">Image</th>
                                    <th style="text-align: center">Particular</th>
                                    <th style="text-align: center">Category</th>
                                    <th style="text-align: center">Amount</th>
                                    <th style="text-align: center">Vat</th>
                                    <th style="text-align: center">Net</th>
                                    <th style="text-align: center">Add/Edit</th>
                                    <th style="text-align: center">Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $data)
                                        @if ($data->status == 0)
                                            <tr>
                                                <td style="text-align: center">{{ $data->id }}</td>
                                                <td style="text-align: center"></td>
                                                <td style="text-align: center">
                                                    @if ($data->image)
                                                        @php
                                                            $ext = pathinfo(storage_path().$data->image, PATHINFO_EXTENSION);
                                                        @endphp
                                                        @if ($ext == 'pdf')
                                                            <div class="row justify-content-center">
                                                                <iframe src="{{asset('images/'.$data->image)}}" width="20%" height="100px">
                                                                        This browser does not support PDFs.Please download the PDF to view it: <a href="{{asset('images/'.$data->image)}}">Download PDF</a>
                                                                </iframe>
                                                            </div>
                                                        @else
                                                        <div class="popup">
                                                            <img src="{{asset('images/'.$data->image)}}" height="100px" width="200px" alt="">
                                                        </div>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td style="text-align: center"></td>
                                                <td style="text-align: center"></td>
                                                <td style="text-align: center"></td>
                                                <td style="text-align: center"></td>
                                                <td style="text-align: center"></td>
                                                <td style="text-align: center">
                                                    <a id="addBtn" rid="{{$data->id}}" uid="{{$data->user_id}}" img="<iframe src='{{asset('images/'.$data->image)}}' width='100%' height='500px'></iframe>"><i class="fa fa-plus" style="color: #21f34f;font-size:16px;"></i></a>
                                                </td>
                                                <td style="text-align: center">
                                                    <a id="deleteBtn" rid="{{$data->id}}"><i class="fa fa-trash-o" style="color: red;font-size:16px;"></i></a>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td style="text-align: center">{{ $data->id }}</td>
                                                <td style="text-align: center">{{$data->account->date}}</td>
                                                <td style="text-align: center">
                                                    @if ($data->image)

                                                        @php
                                                            $ext = pathinfo(storage_path().$data->image, PATHINFO_EXTENSION);
                                                        @endphp
                                                            @if ($ext == 'pdf')
                                                                <div class="row justify-content-center">
                                                                    <iframe src="{{asset('images/'.$data->image)}}" width="20%" height="100px">
                                                                            This browser does not support PDFs.Please download the PDF to view it: <a href="{{asset('images/'.$data->image)}}">Download PDF</a>
                                                                    </iframe>
                                                                </div>
                                                            @else
                                                            <div class="popup">
                                                                <img src="{{asset('images/'.$data->image)}}" height="100px" width="200px" alt="">
                                                            </div>
                                                            @endif
                                                            
                                                        @endif
                                                </td>
                                                <td style="text-align: center">{{$data->account->particular}}</td>
                                                <td style="text-align: center">{{$data->account->category}}</td>
                                                <td style="text-align: center">{{$data->account->amount}}</td>
                                                <td style="text-align: center">{{$data->account->vat}}</td>
                                                <td style="text-align: center">{{$data->account->net}}</td>
                                                <td style="text-align: center">
                                                    @if ($data->status == 0)
                                                        <a id="addBtn" rid="{{$data->id}}" uid="{{$data->user_id}}" img="<iframe src='{{asset('images/'.$data->image)}}' width='100%' height='500px'></iframe>"><i class="fa fa-plus" style="color: #21f34f;font-size:16px;"></i></a>
                                                    @else
                                                        <a id="EditBtn" rid="{{$data->account->id}}" img="<iframe src='{{asset('images/'.$data->image)}}' width='100%' height='500px'></iframe>"><i class="fa fa-plus" style="color: #21f34f;font-size:16px;"></i></a>
                                                    @endif
                                                </td>
                                                <td style="text-align: center">
                                                    
                                                </td>
                                            </tr>
                                        @endif
                                        
                                    @endforeach
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- image popup show  --}}
        <div class="show" style="display: none">
            <div class="overlay"></div>
            <div class="img-show">
              <span>X</span>
              <img src="">
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script>
    $(document).ready(function() {
        var table = $('#example').DataTable( {
            order: [[3, 'desc']],
            lengthChange: false,
            buttons: [ 'excel', 'pdf', 'colvis' ]
        } );
     
        table.buttons().container()
            .appendTo( '#example_wrapper .col-md-6:eq(0)' );
    } );
    $(function () {
    "use strict";
    
        $(".popup img").click(function () {
            var $src = $(this).attr("src");
            $(".show").fadeIn();
            $(".img-show img").attr("src", $src);
        });
        
        $("span, .overlay").click(function () {
            $(".show").fadeOut();
        });
        
    });
    </script>
    <script>
        
        var storedFiles = [];
        $(document).ready(function () {
            $("#addThisFormContainer").hide();
            $("#addNewFormContainer").hide();
            $("#newBtn").click(function(){
                clearform();
                $("#newBtn").hide(100); 
                $("#backBtn").hide(100); 
                $("#addThisFormContainer").hide(300);
                $("#addNewFormContainer").show(300);

            });
            $("#FormCloseBtn").click(function(){
                $("#addNewFormContainer").hide(200);
                $("#addThisFormContainer").hide(200);
                $("#newBtn").show(100); 
                $("#backBtn").show(100); 
                clearform();
            });

            $("#CloseBtn").click(function(){
                $("#addNewFormContainer").hide(200);
                $("#addThisFormContainer").hide(200);
                $("#newBtn").show(100); 
                $("#backBtn").show(100); 
                clearform();
            });
            //header for csrf-token is must in laravel
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            //
            var url = "{{URL::to('/admin/account')}}";
            var createurl = "{{URL::to('/new-account')}}";
            var upurl = "{{URL::to('/admin/account-update')}}";
            // console.log(url);
            $("#addImgDtlBtn").click(function(){
                if($(this).val() == 'Create') {
                    
                    var form_data = new FormData();
                    form_data.append("date", $("#date").val());
                    form_data.append("dataid", $("#dataid").val());
                    form_data.append("uid", $("#uid").val());
                    form_data.append("particular", $("#particular").val());
                    form_data.append("category", $("#category").val());
                    form_data.append("amount", $("#amount").val());
                    form_data.append("vat", $("#vat").val());
                    form_data.append("net", $("#net").val());

                    $.ajax({
                      url: url,
                      method: "POST",
                      contentType: false,
                      processData: false,
                      data:form_data,
                      success: function (d) {
                          if (d.status == 303) {
                                pagetop();
                                $(".ermsg").html(d.message);
                          }else if(d.status == 300){
                                pagetop();
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

                // update 
                if($(this).val() == 'Update') {
                    
                    var form_data = new FormData();

                    form_data.append("date", $("#date").val());
                    form_data.append("dataid", $("#dataid").val());
                    form_data.append("uid", $("#uid").val());
                    form_data.append("particular", $("#particular").val());
                    form_data.append("category", $("#category").val());
                    form_data.append("amount", $("#amount").val());
                    form_data.append("vat", $("#vat").val());
                    form_data.append("net", $("#net").val());

                    $.ajax({
                      url: upurl,
                      method: "POST",
                      contentType: false,
                      processData: false,
                      data:form_data,
                      success: function (d) {
                          if (d.status == 303) {
                                pagetop();
                                $(".ermsg").html(d.message);
                          }else if(d.status == 300){
                                pagetop();
                                success("Data Updated Successfully!!");
                                window.setTimeout(function(){location.reload()},2000)
                          }
                      },
                      error: function (d) {
                          console.log(d);
                      }
                  });
                }
                // update end 
            });
            //Edit
            $("#contentContainer").on('click','#EditBtn', function(){
                //alert("btn work");
                codeid = $(this).attr('rid');
                img = $(this).attr('img');
                $(".showimg").html(img);
                // console.log(img);
                info_url = url + '/'+codeid+'/edit';
                //console.log($info_url);
                $.get(info_url,{},function(d){
                    console.log(d);
                    populateForm(d);
                    pagetop();
                });
            });
            //Edit  end
            // Add 
            $("#contentContainer").on('click','#addBtn', function(){
                
                codeid = $(this).attr('rid');
                uid = $(this).attr('uid');
                img = $(this).attr('img');
                
                $(".showimg").html(img);
                $("#dataid").val(codeid);
                $("#uid").val(uid);
                $("#addThisFormContainer").show(300);
                $("#backBtn").hide(300);
                $("#newBtn").hide(300);
                    pagetop();
            });
            // Add end
            //Delete 
            $("#contentContainer").on('click','#deleteBtn', function(){
                var dataid = $(this).attr('rid');
                var info_url = url + '/'+dataid;
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


            // add new transaction
            $("#createNewBtn").click(function(){
                var form_data = new FormData();
                for(var i=0, len=storedFiles.length; i<len; i++) {
                        form_data.append('media[]', storedFiles[i]);
                    }
                form_data.append("date", $("#date").val());
                form_data.append("newuid", $("#newuid").val());
                form_data.append("firm_id", $("#firm_id").val());

                $.ajax({
                    url: createurl,
                    method: "POST",
                    contentType: false,
                    processData: false,
                    data:form_data,
                    success: function (d) {
                        if (d.status == 303) {
                            $(".ermsg").html(d.message);
                        }else if(d.status == 300){
                            success("Data Created Successfully!!");
                            window.setTimeout(function(){location.reload()},2000)
                        }
                    },
                    error: function (d) {
                        console.log(d);
                    }
                });

            });
            // add new transaction end



            function populateForm(data){
                $("#amount").val(data.amount);
                $("#category").val(data.category);
                $("#date").val(data.date);
                $("#expense").val(data.expense);
                $("#income").val(data.income);
                $("#net").val(data.net);
                $("#vat").val(data.vat);
                $("#particular").val(data.particular);
                $("#others").val(data.others);
                $("#dataid").val(data.id);
                $("#addImgDtlBtn").val('Update');
                $("#addThisFormContainer").show(300);
                $("#backBtn").hide(100);
                $("#newBtn").hide(100); 
            }
            function clearform(){
                $('#createThisForm')[0].reset();
                $("#addImgDtlBtn").val('Create');
            }


          //calculation end
          $("#amount, #vat").keyup(function(){
                var amount = Number($("#amount").val());
                var vat = Number($("#vat").val());
                var net = amount + vat;
                $('#net').val(net.toFixed(2));
            });
            //calculation end  

            //calculation end
          $("#newamount, #newvat").keyup(function(){
                var amount = Number($("#newamount").val());
                var vat = Number($("#newvat").val());
                var net = amount + vat;
                $('#newnet').val(net.toFixed(2));
            });
            //calculation end 

        });

        // gallery images
        /* WHEN YOU UPLOAD ONE OR MULTIPLE FILES */
        $(document).on('change','#media',function(){
            len_files = $("#media").prop("files").length;
            var construc = "<div class='row'>";
            for (var i = 0; i < len_files; i++) {
                var file_data2 = $("#media").prop("files")[i];
                storedFiles.push(file_data2);
                construc += '<div class="col-3 singleImage my-3"><span data-file="'+file_data2.name+'" class="btn ' +
                    'btn-sm btn-danger imageremove2">&times;</span><img width="120px" height="auto" src="' +  window.URL.createObjectURL(file_data2) + '" alt="'  +  file_data2.name  + '" /></div>';
            }
            construc += "</div>";
            $('.preview2').append(construc);
        });

        $(".preview2").on('click','span.imageremove2',function(){
            var trash = $(this).data("file");
            for(var i=0;i<storedFiles.length;i++) {
                if(storedFiles[i].name === trash) {
                    storedFiles.splice(i,1);
                    break;
                }
            }
            $(this).parent().remove();

        });

        
    </script>

    <script>
        function copyToClipboard(id) {
            document.getElementById(id).select();
            document.execCommand('copy');
            swal("Copied!");
        }
    </script>

    
    <script type="text/javascript">
        $(document).ready(function() {
            $("#image").addClass('active');
        });
    </script>
@endsection
