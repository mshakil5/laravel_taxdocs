
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html">
    <title>Invoice</title>
    <link href="{{ asset('user/css/bootstrap.min.css')}}" rel="stylesheet">

    <style>
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    
    <section class="invoice">
        <div class="container-fluid p-0">
            <div class="invoice-body py-5 position-relative">
                <div style="max-width: 1170px; margin: 20px auto;">
                    

                    <table style="width: 100%;">
                        <tbody>
                            <tr>
                                <td colspan="2" class="" style="border :0px solid #dee2e6;width:50%;">
                                    <div class="col-lg-2" style="flex: 2; text-align: left;">
                                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/'.$data->image))) }}" width="120px" style="display:inline-block;"/>
                                    </div>
                                </td>
                                <td colspan="2" class="" style="border :0px solid #dee2e6 ;width:50%;"></td>
                                <td colspan="2" class="" style="border :0px solid #dee2e6 ;">
                                    <div class="col-lg-2" style="flex: 2; text-align: right;">
                                        <h1 style="font-size: 40px; color:blue">INVOICE</h1>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="" style="border :0px solid #dee2e6;width:25%;">
                                </td>
                                <td colspan="2" class="" style="border :0px solid #dee2e6 ;width:50%;"></td>
                                <td colspan="2" class="" style="border :0px solid #dee2e6 ;">
                                </td>
                            </tr>
                        </tbody>
                        
                    </table>

                    <br><br>

                    <table style="width: 100%;">
                        <tbody>

                            <tr>
                                <td colspan="2" class="" style="border :0px solid #828283 ;width:40%;">
                                    <div class="col-lg-2 text-end" style="flex: 2; text-align: right;">
                                        <h5 style="font-size: .90rem; margin : 5px;text-align: left;">Invoice To</h5>
                                        <h5 style="font-size: .90rem; margin : 5px;text-align: left;">{{ \App\Models\NewUser::where('id',$data->new_user_id)->first()->name}}</h5>
                                        <h5 style="font-size: .90rem; margin : 5px;text-align: left;">{{ $data->billing_address}}</h5>
                                        <h5 style="font-size: .90rem; margin : 5px;text-align: left;">{{ $data->email}}</h5>
                                    </div>
                                </td>

                                <td colspan="2" class="" style="border :0px solid #dee2e6;width:30%;"></td>
                                <td colspan="2" class="" style="border :0px solid #dee2e6 ;">
                                    <div class="col-lg-2 text-end" style="flex: 2; text-align: right;">
                                        <h5 style="font-size: .90rem; margin : 5px;text-align: right;">Invoice No: {{ $data->invoiceid}}</h5>
                                        <h5 style="font-size: .90rem; margin : 5px;text-align: right;">Date: {{$data->invoice_date}}</h5>
                                    </div>
                                </td>
                            </tr>
                            
                        </tbody>
                        
                    </table>
                    <br>



                    <div class="row overflow">
                        <table style="width: 100%;border-collapse: collapse;" class="table table-striped">
                            <thead>
                                <tr>
                                    <td  style="border: 1px solid #dee2e6!important; padding: 0 10px 0 10;text-align:center;background-color: #d5d0cf;">Description</td>
                                    <td  style="border: 1px solid #dee2e6!important; padding: 0 10px 0 10;text-align:center;background-color: #d5d0cf;">Qty</td>
                                    <td  style="border: 1px solid #dee2e6!important; padding: 0 10px 0 10;text-align:center;background-color: #d5d0cf;">Price</td>
                                    <td  style="border: 1px solid #dee2e6!important; padding: 0 10px 0 10;text-align:center;background-color: #d5d0cf;">Vat Amount</td>
                                    <td  style="border: 1px solid #dee2e6!important; padding: 0 10px 0 10;text-align:center;background-color: #d5d0cf;">Total (Exc VAT)</td>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($data->invoicedetail as $key => $invoicedtl)
                                @if ($key % 2 == 0)
                                    <tr style="border-bottom:1px solid #dee2e6; border-right:1px solid #dee2e6; border-left:1px solid #dee2e6;">
                                        <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;">{{$invoicedtl->description}}  </td>
                                        <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:center;width: 10%">{{$invoicedtl->quantity}} </td>
                                        <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:right;width: 10%">£{{ number_format($invoicedtl->unit_rate, 2) }}</td>
                                        <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:right;width: 15%">£{{ number_format($invoicedtl->vat, 2) }}</td>
                                        <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:right;width: 20%">£{{ number_format($invoicedtl->quantity * $invoicedtl->unit_rate, 2) }}</td>
                                    </tr>
                                @else
                                    <tr style="border-bottom:1px solid #dee2e6; border-right:1px solid #dee2e6; border-left:1px solid #dee2e6; background-color: #f2f2f2">
                                        <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;">{{$invoicedtl->description}}  </td>
                                        <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:center;width: 10%">{{$invoicedtl->quantity}} </td>
                                        <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:right;width: 10%">£{{ number_format($invoicedtl->unit_rate, 2) }}</td>
                                        <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:right;width: 15%">£{{ number_format($invoicedtl->vat, 2) }}</td>
                                        <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:right;width: 20%">£{{ number_format($invoicedtl->quantity * $invoicedtl->unit_rate, 2) }}</td>
                                    </tr>
                                @endif

                                @endforeach
                            </tbody>
                        </table>  
                                

                        <table style="width: 100%;border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">&nbsp;</td>
                                    <td style="width: 25%">&nbsp;</td>
                                    <td style="width: 25%">&nbsp;</td>
                                    <td>Subtotal</td>
                                    <td style="text-align:right">£{{ number_format($data->subtotal, 2) }}</td>
                                </tr>

                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>VAT</td>
                                    <td style="text-align:right">£{{ number_format($data->vat, 2) }}</td>
                                </tr>

                                @if ($data->discount > 0)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Discount</td>
                                    <td style="text-align:right">£{{ number_format($data->discount, 2) }}</td>
                                </tr>
                                @endif
                                
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>&nbsp;</td>
                                    <td style="background-color: #f2f2f2">Total</td>
                                    <td style="text-align:right; background-color: #f2f2f2">£{{ number_format($data->total, 2) }}</td>
                                </tr>

                            </tbody>
                            <tfoot  style="border :0px solid #dee2e6 ; width: 100%; ">

                            </tfoot>
                        </table>
                    </div>


                    
                    <br><br>


                    <div class="row overflow" style="position:fixed; bottom:0; width:100%; ">
                        <table style="width: 100%;">
                            <tbody>

                                <tr>
                                    <td style="border :0px solid #828283 ;width:100%;">
                                        {{ $data->message_on_invoice}}
                                    </td>
                                </tr>
                                
                            </tbody>
                            
                        </table><br>
                        <hr>
                        <table style="width:100%;border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th style="width: 25%"></th>
                                    <th style="width: 5%"></th>
                                    <th style="width: 20%"></th>
                                    <th style="width: 10%"></th>
                                    <th style="width: 20%"></th>
                                    <th style="width: 20%"></th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td style="width: 20%; text-align:left;" colspan="2"><b>{{$data->company_name}}</b></td>
                                    <td style="width: 20%; text-align:left;" colspan="2"><b> Contact Information</b></td>
                                    <td style="width: 15%; text-align:left;" colspan="2"><b> Payment Details</b></td>
                                </tr>
                                
                                <tr>
                                    <td>{{ $data->company_street_name}}</td>
                                    <td>&nbsp;</td>
                                    <td>{{ $data->name }}</td>
                                    <td>&nbsp;</td>
                                    <td>Bank:</td>
                                    <td style="text-align:right">{{ $data->bank}}</td>
                                </tr>

                                <tr>
                                    <td>{{ $data->company_town}}</td>
                                    <td>&nbsp;</td>
                                    <td>{{ $data->billing_address }}</td>
                                    <td>&nbsp;</td>
                                    <td>A/C No:</td>
                                    <td style="text-align:right">{{ $data->acct_no}}</td>
                                </tr>

                                <tr>
                                    <td>VAT #{{ $data->company_vatno}}</td>
                                    <td>&nbsp;</td>
                                    <td>{{ $data->email}}</td>
                                    <td>&nbsp;</td>
                                    <td>Sort Code:</td>
                                    <td style="text-align:right">{{ $data->short_code}}</td>
                                </tr>
                                <tr>
                                    <td>{{ $data->company_email}}</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                

                            </tbody>
                            
                        </table>
                    </div>

                    
                </div>
            </div>
            
        </div>
    </section>



</body>
</html>

