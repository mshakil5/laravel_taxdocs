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
            <div class="row mb-3 py-3">
                <div class="col-md-3 mb-2">
                    <label> Date<span style="color: red">*</span></label>
                    <input type="date" placeholder="Date" id="date" name="date"  class="form-control" value="@if(isset($data->date)){{$data->date}}@else{{date('Y-m-d')}}@endif">
                    <input type="hidden"  id="payroll_id" name="payroll_id"  class="form-control" value="@if(isset($data->id)){{ $data->id }}@endif">
                </div>
                
                <div class="col-md-3 mb-2">
                    <label> Company Name<span style="color: red">*</span></label>
                    <input type="text" id="company_name" name="company_name" class="form-control" value="@if(isset($data->company_name)){{ $data->company_name }} @endif">
                </div>

                <div class="col-md-3 mb-2">
                    <label> Payroll Period<span style="color: red">*</span></label>
                    <input type="text" placeholder="Payroll Period" id="payroll_period" name="payroll_period" class="form-control" value="@if(isset($data->payroll_period)){{ $data->payroll_period }} @endif">
                </div>

                <div class="col-md-3 mb-2">
                    <label> Frequency<span style="color: red">*</span></label>
                    <select name="frequency" max-width="100px" id="frequency" class="form-control" aria-placeholder="Frequency">
                        <option value>Select Frequency</option>
                        <option value="7" @if(isset($data->frequency)) @if ($data->frequency == 7) selected @endif @endif>Weekly</option>
                        <option value="30" @if(isset($data->frequency)) @if ($data->frequency == 30) selected @endif @endif>Monthly</option>
                        <option value="1" @if(isset($data->frequency)) @if ($data->frequency == 1) selected @endif @endif>Fortnight</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 text-muted bg-white ">
                <div class="ermsg"></div>
                   

                    <div class="row">

                        {{-- new  --}}
                        <div class="fw-bold fs-23 txt-secondary border-bottom pb-2">Others Information</div> <br>
                        <div class="data-container">
                            <table class="table table-theme mt-0">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Name</th>
                                        <th scope="col">National Insurance</th>
                                        <th scope="col">Pay Rate</th>
                                        <th scope="col">Working Hours</th>
                                        <th scope="col">Holiday Hours</th>
                                        <th scope="col">Overtime Hours</th>
                                        <th scope="col">Total Paid Hours</th>
                                        <th scope="col">Note</th>

                                    </tr>
                                </thead>
                                <tbody id="inner">

                                    @if (isset($data))
                                        
                                        @foreach ($data->payrolldetail as $payrolldts)
                                            <tr class="item-row" style="position:realative;">
                                                <td class="px-1">
                                                    <div style="color: white;  user-select:none;  padding: 5px;    background: red;    width: 45px;    display: flex;    align-items: center; margin-right:5px;   justify-content: center;    border-radius: 4px;   left: 4px;    top: 8px;" onclick="removeRow(event)" >X</div>
                                                </td>
                                                <td class="px-1">
                                                    <input class="form-control" name="name[]" type="text" placeholder="Name" value="{{ $payrolldts->name }}">
                                                    <input class="form-control" name="payrolldtl_id[]" type="hidden" placeholder="Name" value="{{ $payrolldts->id }}">
                                                </td>
                                                <td class="fs-16 txt-secondary px-1">
                                                    <input class="form-control" name="national_insurance[]"  placeholder="National Insurance" value="{{ $payrolldts->national_insurance }}">
                                                </td>
                                                <td class="fs-16 txt-secondary px-1">
                                                    <input style="min-width: 50px;"  type="number" name="pay_rate[]" class="form-control" placeholder="Pay Rate" value="{{ $payrolldts->pay_rate }}">
                                                </td>

                                                <td class="fs-16 txt-secondary px-1">
                                                    <input style="min-width: 50px;"  type="number" name="working_hour[]" class="form-control working_hour"  value="{{ $payrolldts->working_hour }}" min="0">
                                                </td>

                                                <td class="fs-16 txt-secondary px-1">
                                                    <input style="min-width: 50px;"  type="number" name="holiday_hour[]" class="form-control holiday_hour"  value="{{ $payrolldts->holiday_hour }}" min="0">
                                                </td>

                                                <td class="fs-16 txt-secondary px-1">
                                                    <input style="min-width: 50px;"  type="number" name="overtime_hour[]" class="form-control overtime_hour"  value="{{ $payrolldts->overtime_hour }}" min="0">
                                                </td>

                                                <td class="fs-16 txt-secondary px-1">
                                                    <input style="min-width: 50px;"  type="number" name="total_paid_hour[]" class="form-control total_paid_hour" readonly min="0"  value="{{ $payrolldts->total_paid_hour }}" placeholder="Total Paid Hour">
                                                </td>
                                                
                                                <td class="text-center">
                                                    <input style="min-width: 50px;"  type="text" name="note[]" class="form-control" placeholder="Note"  value="{{ $payrolldts->note }}">
                                                </td>
                                            </tr>
                                        @endforeach

                                    @else

                                        <tr class="item-row" style="position:realative;">
                                            <td class="px-1">
                                                <div style="color: white;  user-select:none;  padding: 5px;    background: red;    width: 45px;    display: flex;    align-items: center; margin-right:5px;   justify-content: center;    border-radius: 4px;   left: 4px;    top: 8px;" onclick="removeRow(event)" >X</div>
                                            </td>
                                            <td class="px-1">
                                                <input class="form-control" name="name[]" type="text" placeholder="Name">
                                            </td>
                                            <td class="fs-16 txt-secondary px-1">
                                                <input class="form-control" name="national_insurance[]"  placeholder="National Insurance">
                                            </td>
                                            <td class="fs-16 txt-secondary px-1">
                                                <input style="min-width: 50px;"  type="number" name="pay_rate[]" class="form-control" placeholder="Pay Rate">
                                            </td>

                                            <td class="fs-16 txt-secondary px-1">
                                                <input style="min-width: 50px;"  type="number" name="working_hour[]" class="form-control working_hour" value="0" min="0">
                                            </td>

                                            <td class="fs-16 txt-secondary px-1">
                                                <input style="min-width: 50px;"  type="number" name="holiday_hour[]" class="form-control holiday_hour" value="0" min="0">
                                            </td>

                                            <td class="fs-16 txt-secondary px-1">
                                                <input style="min-width: 50px;"  type="number" name="overtime_hour[]" class="form-control overtime_hour" value="0" min="0">
                                            </td>

                                            <td class="fs-16 txt-secondary px-1">
                                                <input style="min-width: 50px;"  type="number" name="total_paid_hour[]" class="form-control total_paid_hour" readonly min="0" placeholder="Total Paid Hour">
                                            </td>
                                            
                                            <td class="text-center">
                                                <input style="min-width: 50px;"  type="text" name="note[]" class="form-control" placeholder="Note">
                                            </td>
                                        </tr>
                                        
                                    @endif

                                    

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="10">
                                            <span class="fs16 txt-primary add-row" type="submit" >Add +</span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        {{-- new  --}}
                        
                        
                    </div>

                    <div class="row">
                        
                        <div class="col-md-12 my-2">
                            @if (isset($data))
                                <button class="text-white btn-theme ml-1" id="addBtn" type="submit"> Update </button>
                            @else
                                <button class="text-white btn-theme ml-1" id="addBtn" type="submit"> Submit </button>
                            @endif
                            
                        </div>
                    </div>
            </div>
        

    </section>



    <section class="data-container"> 
        <table class="table table-custom shadow-sm bg-white contentContainer" id="example">
            <thead>
                <tr> 
                    <th style="text-align: center">Sl</th>
                    <th style="text-align: center">Date</th>
                    <th style="text-align: center">Company Name</th>
                    <th style="text-align: center">Payroll Period</th>
                    <th style="text-align: center">Frequency </th> 
                    <th style="text-align: center">Action </th> 
                </tr>
            </thead>
            <tbody>

                @foreach (\App\Models\Payroll::where('user_id',Auth::user()->id)->orderby('id','DESC')->get() as $key => $data)
                <tr>
                  <td style="text-align: center">{{ $key + 1 }}</td>
                  <td style="text-align: center">{{ $data->date }}</td>
                  <td style="text-align: center">{{ $data->company_name }}</td>
                  <td style="text-align: center">{{ $data->payroll_period }}</td>
                  <td style="text-align: center">@if ($data->frequency == 7) Weekly @else Monthly @endif</td>
                  
                  <td style="text-align: center">
                    <a  href="{{ route('user.payrolldtl',encrypt($data->id))}}" class="text-white btn-theme">Show</a>
                  </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </section> 

</div>




@endsection
@section('script')
<script type="text/javascript">
    function removeRow(event) {
        event.target.parentElement.parentElement.remove();
    }
</script>
<script>
    $(document).ready(function () {
        $(".add-row").click(function() {
            var markup =
                '<tr class="item-row" style="position:realative"><td class="px-1"><div style="color:#fff;user-select:none;padding:5px;background:red;width:45px;display:flex;align-items:center;margin-right:5px;justify-content:center;border-radius:4px;left:4px;top:8px" onclick="removeRow(event)">X</div></td><td class="px-1"><input class="form-control" name="name[]" type="text" placeholder="Name"></td><td class="fs-16 txt-secondary px-1"><input class="form-control" name="national_insurance[]" placeholder="National Insurance"></td><td class="fs-16 txt-secondary px-1"><input style="min-width:50px" type="number" name="pay_rate[]" class="form-control" placeholder="Pay Rate"></td><td class="fs-16 txt-secondary px-1"><input style="min-width:50px" type="number" name="working_hour[]" class="form-control working_hour" value="0"></td><td class="fs-16 txt-secondary px-1"><input style="min-width:50px" type="number" name="holiday_hour[]" class="form-control holiday_hour" value="0"></td><td class="fs-16 txt-secondary px-1"><input style="min-width:50px" type="number" name="overtime_hour[]" class="form-control overtime_hour" value="0"></td><td class="fs-16 txt-secondary px-1"><input style="min-width:50px" type="number" name="total_paid_hour[]" class="form-control total_paid_hour" readonly placeholder="Total Paid Hour"></td><td class="text-center"><input style="min-width:50px" type="text" name="note[]" class="form-control" placeholder="Note"></td></tr>';

            $("table #inner").append(markup);
        });

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
        // submit to payrollurl 
        var payrollurl = "{{URL::to('/user/payroll')}}";

            $("body").delegate("#addBtn","click",function(event){
                event.preventDefault();

                var date = $("#date").val();
                var company_name = $("#company_name").val();
                var payroll_period = $("#payroll_period").val();
                var frequency = $("#frequency").val();
                

                var name = $("input[name='name[]']")
                    .map(function(){return $(this).val();}).get();

                var national_insurance = $("input[name='national_insurance[]']")
                    .map(function(){return $(this).val();}).get();

                var pay_rate = $("input[name='pay_rate[]']")
                    .map(function(){return $(this).val();}).get();
                    
                var working_hour = $("input[name='working_hour[]']")
                    .map(function(){return $(this).val();}).get();

                var holiday_hour = $("input[name='holiday_hour[]']")
                    .map(function(){return $(this).val();}).get();

                var overtime_hour = $("input[name='overtime_hour[]']")
                    .map(function(){return $(this).val();}).get();

                var total_paid_hour = $("input[name='total_paid_hour[]']")
                    .map(function(){return $(this).val();}).get();

                var note = $("input[name='note[]']")
                    .map(function(){return $(this).val();}).get();

                $.ajax({
                    url: payrollurl,
                    method: "POST",
                    data: {date,payroll_period,company_name,name,national_insurance,frequency,pay_rate,working_hour,holiday_hour,overtime_hour,total_paid_hour,note},

                    success: function (d) {
                        if (d.status == 303) {
                            $(".ermsg").html(d.message);
                            pagetop();
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

        });
        // submit to purchase end

        //  regular income update
        var upurl = "{{URL::to('/user/payroll-update')}}";
            $("#updateBtn").click(function(){

                var date = $("#date").val();
                var company_name = $("#company_name").val();
                var payroll_period = $("#payroll_period").val();
                var payroll_id = $("#payroll_id").val();
                var frequency = $("#frequency").val();
                

                var name = $("input[name='name[]']")
                    .map(function(){return $(this).val();}).get();

                var payrolldtl_id = $("input[name='payrolldtl_id[]']")
                    .map(function(){return $(this).val();}).get();

                var national_insurance = $("input[name='national_insurance[]']")
                    .map(function(){return $(this).val();}).get();

                var pay_rate = $("input[name='pay_rate[]']")
                    .map(function(){return $(this).val();}).get();
                    
                var working_hour = $("input[name='working_hour[]']")
                    .map(function(){return $(this).val();}).get();

                var holiday_hour = $("input[name='holiday_hour[]']")
                    .map(function(){return $(this).val();}).get();

                var overtime_hour = $("input[name='overtime_hour[]']")
                    .map(function(){return $(this).val();}).get();

                var total_paid_hour = $("input[name='total_paid_hour[]']")
                    .map(function(){return $(this).val();}).get();

                var note = $("input[name='note[]']")
                    .map(function(){return $(this).val();}).get();

                    $.ajax({
                      url: upurl,
                      method: "POST",
                      data: {date,payroll_id,company_name,payroll_period,frequency,national_insurance,name,holiday_hour,working_hour,pay_rate,note,total_paid_hour,overtime_hour,payrolldtl_id},
                      success: function (d) {
                          if (d.status == 303) {
                              $(".ermsg").html(d.message);
                          }else if(d.status == 300){
                            $(".ermsg").html(d.message);
                            window.setTimeout(function(){location.reload()},2000)
                          }
                      },
                      error: function (d) {
                          console.log(d);
                      }
                  });
            });



        // unit price calculation

        $("body").delegate(".overtime_hour, .holiday_hour, .working_hour","keyup",function(event){
            event.preventDefault();
            var row = $(this).parent().parent();
            var overtime_hour = row.find('.overtime_hour').val();
            var holiday_hour = row.find('.holiday_hour').val();
            var working_hour = row.find('.working_hour').val();
            var o_hour = parseInt(overtime_hour);
            var h_hour = parseInt(holiday_hour);
            var w_hour = parseInt(working_hour);

            if (isNaN(o_hour)) {
                o_hour = 0;
            }

            if (isNaN(h_hour)) {
                h_hour = 0;
            }
            if (isNaN(w_hour)) {
                w_hour = 0;
            }
            var total_paid_hour = o_hour + h_hour + w_hour;
            row.find('.total_paid_hour').val(total_paid_hour);
        })
        // unit price calculation end

    });

    $(document).ready(function () {
        $('#example').DataTable();
    });

    

</script>

@endsection
