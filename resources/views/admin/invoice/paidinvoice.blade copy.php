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
                                                    <a href="{{ route('admin.invoiceaccadd',encrypt($data->id))}}"><i class="fa fa-plus" style="color: #21f34f;font-size:16px;"></i></a>
                                                    @endif

                                                    
                                                    @if ($data->status == 1)
                                                    <a href="{{ route('admin.invoiceaccedit',encrypt($data->id))}}"><i class="fa fa-edit" style="color: #440aa9;font-size:16px;"></i></a>
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

            
            //header for csrf-token is must in laravel
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            //
            
            

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
