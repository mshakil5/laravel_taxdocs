
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html">
    <title>Invoice</title>
    <script>
        setTimeout(function () {
            window.print();
        }, 800);
    </script>
    <style>
        @media print {
            
            @page {
                margin: 100px auto; /* imprtant to logo margin */
            }

            html, body {
                margin: 50 0 0 0;
                padding: 0
            }

            #printContainer {
                width: 250px;
                margin: auto;
                /*text-align: justify;*/
            }

            .text-center {
                text-align: center;
            }
            .text-right {
                text-align: right;
            }
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
                                            <img src="{{ asset('images/'.$data->image)}}" alt="{{ $data->company_name}}" width="220px" />
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
                                            <h5 style="font-size: .90rem; margin : 5px;text-align: left;">Name: {{ \App\Models\NewUser::where('id',$data->new_user_id)->first()->name}}</h5>
                                            <h5 style="font-size: .90rem; margin : 5px;text-align: left;">Billing Address: {{ $data->billing_address}}</h5>
                                            <h5 style="font-size: .90rem; margin : 5px;text-align: left;">Email: {{ $data->email}}</h5>
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
                        <table style="width: 100%;border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <td  style="border: 1px solid #dee2e6!important; padding: 0 15px;text-align:center">Description</td>
                                    <td  style="border: 1px solid #dee2e6!important; padding: 0 15px;text-align:center">Qty</td>
                                    <td  style="border: 1px solid #dee2e6!important; padding: 0 15px;text-align:center">Price</td>
                                    <td  style="border: 1px solid #dee2e6!important; padding: 0 15px;text-align:center">Vat Amount</td>
                                    <td  style="border: 1px solid #dee2e6!important; padding: 0 15px;text-align:center;">Total (Exc VAT)</td>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($data->invoicedetail as $key => $invoicedtl)
                                <tr style="border-bottom:1px solid #dee2e6 ; border-right:1px solid #dee2e6 ; border-left:1px solid #dee2e6 ;">
                                    <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;">{{$invoicedtl->description}}  </td>
                                    <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:center;width: 10%">{{$invoicedtl->quantity}} </td>
                                    <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:right;width: 10%">£{{ number_format($invoicedtl->unit_rate, 2) }}</td>
                                    <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:right;width: 10%">£{{ number_format($invoicedtl->vat, 2) }}</td>
                                    <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:right;width: 20%">£{{ number_format($invoicedtl->quantity * $invoicedtl->unit_rate, 2) }}</td>
                                </tr>
                                @endforeach
                                
                                <tr style="border-bottom:1px solid #dee2e6 ; border-right:1px solid #dee2e6 ; border-left:1px solid #dee2e6 ;">
                                    <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:center">&nbsp;</td>
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
                                    <td style="text-align:right">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td colspan="2" rowspan="3"></td>
                                    <td>&nbsp;</td>
                                    <td>Subtotal</td>
                                    <td style="text-align:right">£{{ $data->subtotal}}</td>
                                </tr>

                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Vat</td>
                                    <td style="text-align:right">£{{ $data->vat}}</td>
                                </tr>

                                @if ($data->discount > 0)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Discount</td>
                                    <td style="text-align:right">£{{ $data->discount}}</td>
                                </tr>
                                @endif
                                
                                <tr>
                                    @if ($data->discount > 0)
                                    <td></td>
                                    <td></td>
                                    @endif
                                    <td>&nbsp;</td>
                                    <td>Total</td>
                                    <td style="text-align:right">£{{ $data->total}}</td>
                                </tr>

                            </tbody>
                            <tfoot  style="border :0px solid #dee2e6 ; width: 100%; ">

                            </tfoot>
                        </table>
                    </div><br><br>

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
                                    <th style="width: 20%"></th>
                                    <th style="width: 20%"></th>
                                    <th style="width: 20%"></th>
                                    <th style="width: 10%"></th>
                                    <th style="width: 15%"></th>
                                    <th style="width: 15%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <tr>
                                    <td style="width: 20%">Company Name:</td>
                                    <td style="width: 20%">{{ $data->company_name}}</td>
                                    <td style="width: 20%">&nbsp;</td>
                                    <td style="width: 10%">&nbsp;</td>
                                    <td style="width: 15%">Acct. No:</td>
                                    <td style="text-align:right">{{ $data->acct_no}}</td>
                                </tr>

                                <tr>
                                    <td>Vat No:</td>
                                    <td>{{ $data->company_vatno}}</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Bank:</td>
                                    <td style="text-align:right">{{ $data->bank}}</td>
                                </tr>

                                <tr>
                                    <td>Tell No.</td>
                                    <td>{{ $data->company_tell_no}}</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Sort-code:</td>
                                    <td style="text-align:right">{{ $data->short_code}}</td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td>{{ $data->company_email}}</td>
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

