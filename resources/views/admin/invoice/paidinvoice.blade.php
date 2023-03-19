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
        

        <button id="newBtn" type="button" class="btn btn-info">Add New</button>
        <hr>

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
                                                <th>Sl</th>
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
                                                <td style="text-align: center">{{ $key + 1 }}</td>
                                                <td style="text-align: center">{{ $data->invoice_date }}</td>
                                                <td style="text-align: center">{{ $data->invoiceid }}</td>
                                                <td style="text-align: center">{{ \App\Models\NewUser::where('id',$data->new_user_id)->first()->name }}</td>
                                                <td style="text-align: center">{{ $data->email }}</td>
                                                <td style="text-align: center">{{ $data->billing_address }}</td>
                                                <td style="text-align: center">{{ $data->message_on_invoice }}</td>
                                                <td style="text-align: center">{{ $data->total }}</td>
                                                <td>
                                                    <a href="{{ route('admin.invoicedtl',encrypt($data->id))}}"><i class="fa fa-eye" style="color: #09a311;font-size:16px;"></i></a>
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
        buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
    } );

    
 
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


            //header for csrf-token is must in laravel
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            //

            
           

             

            
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
