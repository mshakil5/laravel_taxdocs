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
     

        <div id="contentContainer">


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3> User Payroll Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="container">
                                    <table class="table table-bordered table-hover" id="example">
                                        <thead>
                                        <tr>
                                            <th style="text-align: center">Sl</th>
                                            <th style="text-align: center">Name</th>
                                            <th style="text-align: center">National Insurance</th>
                                            <th style="text-align: center">Frequency</th>
                                            <th style="text-align: center">Pay Rate</th>
                                            <th style="text-align: center">Total Working Hours</th>
                                            <th style="text-align: center">Holiday Hours</th>
                                            <th style="text-align: center">Overtime Hours</th>
                                            <th style="text-align: center">Total Paid Hours</th>
                                            <th style="text-align: center">Note</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $key =>  $data)
                                            <tr>
                                              <td style="text-align: center">{{ $key + 1 }}</td>
                                              <td style="text-align: center">{{ $data->name }}</td>
                                              <td style="text-align: center">{{ $data->national_insurance }}</td>
                                              <td style="text-align: center">{{ $data->frequency }}</td>
                                              <td style="text-align: center">{{ $data->pay_rate }}</td>
                                              <td style="text-align: center">{{ $data->working_hour }}</td>
                                              <td style="text-align: center">{{ $data->holiday_hour }}</td>
                                              <td style="text-align: center">{{ $data->overtime_hour }}</td>
                                              <td style="text-align: center">{{ $data->total_paid_hour }}</td>
                                              <td style="text-align: center">{{ $data->note }}</td>
                                              
                                              
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
        lengthChange: true,
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
