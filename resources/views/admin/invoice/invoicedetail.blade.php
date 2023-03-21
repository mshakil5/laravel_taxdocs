@extends('admin.layouts.admin')

@section('content')



<main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-file-text-o"></i> Invoice</h1>
      </div>
    </div>

    
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <section class="invoice">
            

            <div class="row invoice-info">
                <div class="col-4"><b>Invoice #{{$data->invoiceid}}</b>
                    <br>
                    <b>Order ID:</b> {{ $data->invoice_date}}<br>
                    <b>Invoice To:</b><br>
                    <b>Name: </b>{{ \App\Models\NewUser::where('id',$data->new_user_id)->first()->name}}<br>
                    <b>Email: </b>{{ $data->email}}<br>
                    <b>Billing Address: </b>{{ $data->billing_address}}<br>
                </div>
              <div class="col-4">
                
                
              </div>


              <div class="col-4">
                
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/'.$data->image))) }}" width="200px" style="display:inline-block;"/>
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
                        <th  style="border: 1px solid #dee2e6!important; padding: 0 15px;">Vat Amount</th>
                        <th  style="border: 1px solid #dee2e6!important; padding: 0 15px;">Total (Exc VAT)</th>
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
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="text-align:right">&nbsp;</td>
                    </tr>

                    <tr>
                        <td colspan="2" rowspan="3">{{ $data->message_on_invoice}}</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>Subtotal</td>
                        <td style="text-align:right">{{ $data->subtotal}}</td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>Vat</td>
                        <td style="text-align:right">{{ $data->vat}}</td>
                    </tr>
                    @if ($data->discount > 0)
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>Discount</td>
                        <td style="text-align:right">{{ $data->discount}}</td>
                    </tr>
                        
                    @endif

                    <tr>
                        @if ($data->discount > 0)
                        <td></td>
                        <td></td>@endif
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>Total</td>
                        <td style="text-align:right">{{ $data->total}}</td>
                    </tr>
                    
                    



                  </tbody>
                </table>
              </div>
            </div>

            <div class="row invoice-info">
                <div class="col-4">
                    <b>Company Name: {{ $data->company_name}}</b><br>
                    <b>Email:</b> {{ $data->company_email}}<br>
                    <b>Vat Number:</b>{{ $data->company_vatno}}<br>
                    <b>Tel No: </b>{{ $data->company_tell_no}}<br>
                </div>
              <div class="col-4">
                
                
              </div>


              <div class="col-4">
                
                <b>	Acct. No: {{ $data->acct_no}}</b><br>
                <b>	Bank:</b> {{ $data->bank}}<br>
                <b>Sort-Code::</b>{{ $data->short_code}}<br>
                
              </div>


            
            </div><br>

            <div class="row d-print-none mt-2">
              <div class="col-12 text-right"><a class="btn btn-primary" href="{{ route('invoice.print',$data->id)}}" target="_blank"><i class="fa fa-print"></i> Print</a></div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </main>


@endsection
@section('script')



  
    
    <script type="text/javascript">
        $(document).ready(function() {
            $("#alluser").addClass('active');
            $("#alluser").addClass('is-expanded');
            $("#user").addClass('active');
        });
    </script>

@endsection
