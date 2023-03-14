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
                                        <th style="text-align: center">Name</th>
                                        <th style="text-align: center">National Insurance</th>
                                        <th style="text-align: center">Frequency</th>
                                        <th style="text-align: center">Pay Rate</th>
                                        <th style="text-align: center">Working Hours</th>
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
    </section> 

</div>




@endsection
@section('script')
<script>

    $(document).ready(function () {
        $('#example').DataTable();
    });

    

</script>

@endsection
