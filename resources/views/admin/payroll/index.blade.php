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
                                            <th style="text-align: center; width:20%">Sl</th>
                                            <th style="text-align: center; width:20%">Date</th>
                                            <th style="text-align: center; width:20%">Company Name</th>
                                            <th style="text-align: center; width:20%">Payroll Period</th>
                                            <th style="text-align: center; width:20%">Action </th> 
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $key => $data)
                                                <tr>
                                                    <td style="text-align: center">{{ $key + 1 }}</td>
                                                    <td style="text-align: center">{{ $data->date }}</td>
                                                    <td style="text-align: center">{{ $data->company_name }}</td>
                                                    <td style="text-align: center">{{ $data->payroll_period }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.payrolldtl', encrypt($data->id) )}}"><span class="badge badge-primary">show</span></a>
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
