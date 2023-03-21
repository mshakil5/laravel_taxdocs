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
                                                <option value="Payable">Payable</option>
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
        </div><br>

        <div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3> User Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="container">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th style="text-align: center; width:20%">Name</th>
                                            <th style="text-align: center; width:20%">Email</th>
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
                                                    <td style="text-align: center">{{ $user->bname }}</td>
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
        </div><br>
        
        <div id="contentContainer">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3> Invoice Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="container" style="max-width: 1200px;">
                                    <table class="table table-bordered table-hover table-responsive" id="example" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Date</th>
                                                <th>Invoice No</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Billing Address</th>
                                                <th>Messege</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $key => $data)
                                            <tr>
                                                <td style="text-align: center">{{ $data->id }}</td>
                                                <td style="text-align: center">{{ $data->invoice_date }}</td>
                                                <td style="text-align: center">{{ $data->invoiceid }}</td>
                                                <td style="text-align: center">{{ \App\Models\NewUser::where('id',$data->new_user_id)->first()->name }}</td>
                                                <td style="text-align: center">{{ $data->email }}</td>
                                                <td style="text-align: center">{{ $data->billing_address }}</td>
                                                <td style="text-align: center">{{ $data->message_on_invoice }}</td>
                                                <td style="text-align: center">{{ $data->total }}</td>
                                                <td>

                                                    <a href="{{ route('admin.invoicedtl',encrypt($data->id))}}"><i class="fa fa-eye" style="color: #09a311;font-size:16px;"></i></a>

                                                    @if ($data->status == 0)
                                                    <a id="addinvoiceBtn" rid="{{$data->id}}" uid="{{$data->user_id}}" ><i class="fa fa-plus" style="color: #21f34f;font-size:16px;"></i></a>
                                                    @endif

                                                    
                                                    @if ($data->status == 1)
                                                    <a href="{{ route('admin.invoiceaccedit',$data->id)}}"><i class="fa fa-edit" style="color: #440aa9;font-size:16px;"></i></a>
                                                    @endif

                                                    
                                                    
                                                    
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
    });
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
});
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

            
            // Add 
            $("#contentContainer").on('click','#addinvoiceBtn', function(){
                
                codeid = $(this).attr('rid');
                uid = $(this).attr('uid');
                
                $("#dataid").val(codeid);
                $("#uid").val(uid);
                $("#addThisFormContainer").show(300);
                    pagetop();
            });
            // Add end


            //header for csrf-token is must in laravel
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            //

            var url = "{{URL::to('/admin/invoice-account')}}";
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

                // update 
                // if($(this).val() == 'Update') {
                    
                //     var form_data = new FormData();

                //     form_data.append("date", $("#date").val());
                //     form_data.append("dataid", $("#dataid").val());
                //     form_data.append("uid", $("#uid").val());
                //     form_data.append("particular", $("#particular").val());
                //     form_data.append("category", $("#category").val());
                //     form_data.append("amount", $("#amount").val());
                //     form_data.append("vat", $("#vat").val());
                //     form_data.append("net", $("#net").val());

                //     $.ajax({
                //       url: upurl,
                //       method: "POST",
                //       contentType: false,
                //       processData: false,
                //       data:form_data,
                //       success: function (d) {
                //           if (d.status == 303) {
                //                 $(".ermsg").html(d.message);
                //           }else if(d.status == 300){
                //                 success("Data Updated Successfully!!");
                //                 window.setTimeout(function(){location.reload()},2000)
                //           }
                //       },
                //       error: function (d) {
                //           console.log(d);
                //       }
                //   });
                // }
                // update end 
            });

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
