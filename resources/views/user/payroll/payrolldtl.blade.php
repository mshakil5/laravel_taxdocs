@extends('layouts.user')
@section('content')
<style>
    .pl25{
        padding-left: 25px;
    }
</style>

<div class="dashboard-content">

    
    <section class="profile purchase-status px-4">

        <div class="title-section">
            <span class="iconify" data-icon="clarity:heart-solid"></span>
            <div class="mx-2"> Payroll Information</div>
        </div>

        <div class="title-section row mt-3">
            <div class="col-md-12">
                <div class="ermsg"></div>
                <div class="col-md-12 text-muted bg-white ">
                        <div class="row mb-3">
                            <div class="col-md-3 ">
                                <label> Date<span style="color: red">*</span></label>
                                <input type="date" placeholder="Date" id="date" name="date"  class="form-control" value="@if(isset($data->date)){{$data->date}}@else{{date('Y-m-d')}}@endif">
                                <input type="hidden"  id="payroll_id" name="payroll_id"  class="form-control" value="@if(isset($data->id)){{ $data->id }}@endif">
                            </div>
                            
                            <div class="col-md-3 ">
                                <label> Company Name<span style="color: red">*</span></label>
                                <input type="text" id="company_name" name="company_name" class="form-control" value="@if(isset($data->company_name)){{ $data->company_name }} @endif">
                            </div>

                            <div class="col-md-3 ">
                                <label> Payroll Period<span style="color: red">*</span></label>
                                <input type="text" placeholder="Payroll Period" id="payroll_period" name="payroll_period" class="form-control" value="@if(isset($data->payroll_period)){{ $data->payroll_period }} @endif">
                            </div>

                            <div class="col-md-3 ">
                                <label> Frequency<span style="color: red">*</span></label>
                                <select name="frequency" max-width="100px" id="frequency" class="form-control" aria-placeholder="Frequency">
                                    <option value>Select Frequency</option>
                                    <option value="7">Weekly</option>
                                    <option value="30">Monthly</option>
                                </select>
                            </div>
                        </div>

                        
                </div>
            </div>
        </div>

    </section>




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

                                    @foreach ($data->payrolldetail as $key =>  $data)
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
