@extends('admin.layouts.admin')

@section('content')



<main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-file-text-o"></i> Invoice</h1>
      </div>
    </div>

    <a href="{{ route('admin.paidinvoice', encrypt($data->user_id))}}" id="backBtn" class="btn btn-info mb-2">Back</a>

    
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <section class="invoice">
            

            <div class="row invoice-info">
                <div class="col-4"><b>Invoice #{{$data->invoiceid}}</b>
                    <br>
                    <b>Date:</b> {{ \Carbon\Carbon::parse($data->invoice_date)->format('d/m/Y') }}<br>
                    <b>Invoice To:</b><br>
                    <b>Name: </b>{{ \App\Models\NewUser::where('id',$data->new_user_id)->first()->name}}<br>
                    <b>Email: </b>{{ $data->email}}<br>
                    <b>Post code: </b>{{ $data->post_code}}<br>
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

            <div class="row invoice-info">
              <div class="col-12">
                  <p>{{ $data->message_on_invoice}}</p><br>
              </div>
            </div><br>

            <div class="row invoice-info">
                <div class="col-4">
                    <b>{{ $data->company_name}}</b><br>
                    <b>{{ $data->company_house_number}} {{ $data->company_street_name}}</b><br>
                    <b>{{ $data->company_town}}</b><br>
                    <b>{{ $data->company_post_code}}</b><br>
                    <b>{{ $data->company_vatno}}</b><br>
                </div>
              <div class="col-5">
                    <b>Contact Information</b><br>
                    <b>{{ $data->company_name }} {{ $data->company_surname }}</b><br>
                    <b>{{ $data->company_tell_no }}</b><br>
                    <b>{{ $data->company_email}}</b><br>
                
              </div>


              <div class="col-3">
                
                <b>	Acct. No: {{ $data->acct_no}}</b><br>
                <b>	Bank:</b> {{ $data->bank}}<br>
                <b> Sort-Code:</b>{{ $data->short_code}}<br>
                
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
