@extends('admin.layouts.admin')


@section('content')



<main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-edit"></i> Invoice Account Edit</h1>
      </div>
      <ul class="app-breadcrumb breadcrumb">
      </ul>
    </div>
    <div class="row">
      <div class="col-md-6">
        
        <div class="tile">
          <section class="invoice">
            

            <div class="row invoice-info">
                <div class="col-8"><b>Invoice #{{$data->invoiceid}}</b>
                    <br>
                    <b>Date:</b> {{ $data->invoice_date}}<br>
                </div>


              <div class="col-4">
                
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/'.$data->image))) }}" width="100px" style="display:inline-block;"/>
              </div>


            
            </div><br>


            






            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                        <th  style="border: 1px solid #dee2e6!important; padding: 0 15px;">#</th>
                        <th  style="border: 1px solid #dee2e6!important; padding: 0 15px;">Description</th>
                        <th  style="border: 1px solid #dee2e6!important; padding: 0 15px;">Qty</th>
                        <th  style="border: 1px solid #dee2e6!important; padding: 0 15px;">Price</th>
                        <th  style="border: 1px solid #dee2e6!important; padding: 0 15px;">Amount</th>
                        <th  style="border: 1px solid #dee2e6!important; padding: 0 15px;">Total <span style="font-size:10px">(Exc VAT)</span> </th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($data->invoicedetail as $key => $invoicedtl)
                        <tr style="border-bottom:1px solid #dee2e6 ; border-right:1px solid #dee2e6 ; border-left:1px solid #dee2e6 ;">
                            <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:center">{{ $key + 1 }}</td>
                            <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;">{{$invoicedtl->description}}  </td>
                            <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:center">{{$invoicedtl->quantity}} </td>
                            <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:right">{{ number_format($invoicedtl->unit_rate, 2) }}</td>
                            <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:right">{{ number_format($invoicedtl->vat, 2) }}</td>
                            <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:right">{{ number_format($invoicedtl->quantity * $invoicedtl->unit_rate, 2) }}</td>
                        </tr>
                    @endforeach

                    <tr style="border-bottom:1px solid #dee2e6 ; border-right:1px solid #dee2e6 ; border-left:1px solid #dee2e6 ;">
                        <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:center">&nbsp;</td>
                        <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;">&nbsp;</td>
                        <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;">&nbsp;</td>
                        <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:center">&nbsp;</td>
                        <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:right">&nbsp;</td>
                        <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:right">&nbsp;</td>
                    </tr>

                    <tr>
                        <td colspan="4" rowspan="3"></td>
                        <td>Subtotal</td>
                        <td style="text-align:right">{{ $data->subtotal}}</td>
                    </tr>

                    <tr>
                        <td>Vat</td>
                        <td style="text-align:right">{{ $data->vat}}</td>
                    </tr>
                    @if ($data->discount > 0)
                    <tr>
                        <td>Discount</td>
                        <td style="text-align:right">{{ $data->discount}}</td>
                    </tr>
                        
                    @endif

                    <tr>
                        @if ($data->discount > 0)
                        <td></td>
                        <td></td>@endif
                        <td>Total</td>
                        <td style="text-align:right">{{ $data->total}}</td>
                    </tr>
                    
                    



                  </tbody>
                </table>
              </div>
            </div>


            <div class="row d-print-none mt-2">
              <div class="col-12 text-right"><a class="btn btn-primary" href="{{ route('invoice.print',$data->id)}}" target="_blank"><i class="fa fa-print"></i> Print</a></div>
            </div>
          </section>
        </div>



      </div>
      <div class="col-md-6">
        <div class="tile">
          <h3 class="tile-title">Account Details</h3>
          <div class="tile-body" id="contentContainer">
            

            <div class="container">

                {!! Form::open(['url' => 'admin/register/admincreate','id'=>'createThisForm']) !!}
                
                <div>
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" class="form-control" value="{{$account->date}}" readonly>
                    <input type="hidden" id="dataid" name="dataid" class="form-control" value="{{$account->id}}" readonly>
                </div>

                <div>
                    <label for="particular">Particular</label>
                    <input type="text" id="particular" name="particular" class="form-control" value="{{$account->particular}}" readonly>
                </div>
                
                <div>
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-control" readonly>
                        <option value="">Select</option>
                        <option value="Receivable" @if ($account->category == 'Receivable') selected @endif>Receivable</option>
                        <option value="Payable" @if ($account->category == 'Payable') selected @endif>Payable</option>
                    </select>
                </div>

                <div>
                    <label for="amount">Amount</label>
                    <input type="number" id="amount" name="amount" class="form-control" value="{{$account->amount}}" readonly>
                </div>

                <div>
                    <label for="vat">Vat Amount</label>
                    <input type="number" id="vat" name="vat" class="form-control" value="{{$account->vat}}" readonly>
                </div>
                <div>
                    <label for="net">Net</label>
                    <input type="number" id="net" name="net" class="form-control"  value="{{$account->net}}" readonly>
                </div>

            </div>
            <hr>
            <input type="button" id="editBtn" value="Edit" class="btn btn-primary">
            <input type="button" id="FormCloseBtn" value="Close" class="btn btn-warning">
            {!! Form::close() !!}
            

          </div>
        </div>
      </div>
      
    </div>
  </main>



@endsection
@section('script')

<script>
    $(document).ready(function () {
        
        //header for csrf-token is must in laravel
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        //
        
        
        var url = "{{URL::to('/admin/invoice-account/update')}}";
            // console.log(url);
            $("#editBtn").click(function(){
                //Update
                if($(this).val() == 'Update'){
                    
                    var form_data = new FormData();
                    
                    form_data.append("date", $("#date").val());
                    form_data.append("particular", $("#particular").val());
                    form_data.append("dataid", $("#dataid").val());
                    form_data.append("category", $("#category").val());
                    form_data.append("amount", $("#amount").val());
                    form_data.append("vat", $("#vat").val());
                    form_data.append("net", $("#net").val());
                    
                    $.ajax({
                        url:url,
                        type: "POST",
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        data:form_data,
                        success: function(d){
                            console.log(d);
                            if (d.status == 303) {
                                $(".ermsg").html(d.message);
                                pagetop();
                            }else if(d.status == 300){
                                success("Data Update Successfully!!");
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
        $("#contentContainer").on('click','#editBtn', function(){
            $('#date').removeAttr("readonly");
            $('#particular').removeAttr("readonly");
            $('#category').removeAttr("readonly");
            $('#amount').removeAttr("readonly");
            $('#vat').removeAttr("readonly");
            $("#editBtn").val('Update');
            
        });
        //Edit  end

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
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#alluser").addClass('active');
        $("#alluser").addClass('is-expanded');
        $("#user").addClass('active');
    });
</script>

@endsection
