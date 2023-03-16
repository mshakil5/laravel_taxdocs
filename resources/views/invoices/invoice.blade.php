
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html">
    <title>Invoice</title>
</head>

<body>
    <section class="invoice">
        <div class="container-fluid p-0">
            <div class="invoice-body py-5">
                <div style="  max-width: 1170px; margin: 70px auto;">
                    

                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="" style="border :0px solid #dee2e6 ;width:80%;">
                                        <div class="col-lg-2 text-end" style="flex: 2; text-align: right;">
                                            <h5 style="font-size: .90rem; margin : 5px;text-align: left;">Invoice No: {{ $data->invoiceid}}</h5>
                                            <h5 style="font-size: .90rem; margin : 5px;text-align: left;">Date: {{ $data->date}}</h5>
                                            <h5 style="font-size: .90rem; margin : 5px;text-align: left;">Terms: {{ $data->terms}}</h5>
                                        </div>
                                    </td>

                                    <td colspan="2" class="" style="border :0px solid #dee2e6 ;width:80%;"></td>
                                    <td colspan="2" class="" style="border :0px solid #dee2e6 ;">
                                        <div class="col-lg-2 text-end" style="flex: 2; text-align: right;">
                                            <img src="{{ asset('images/'.$data->image)}}" alt="Logo" width="270px" />
                                        </div>
                                    </td>
                                </tr>


                                <tr>
                                    <td colspan="2" class="" style="border :0px solid #828283 ;width:80%;">
                                        <div class="col-lg-2 text-end" style="flex: 2; text-align: right;">
                                            <h5 style="font-size: .90rem; margin : 5px;text-align: left;">Invoice To</h5>
                                            <h5 style="font-size: .90rem; margin : 5px;text-align: left;">Name: {{ \App\Models\NewUser::where('id',$data->new_user_id)->first()->name}}</h5>
                                            <h5 style="font-size: .90rem; margin : 5px;text-align: left;">Email: {{ $data->email}}</h5>
                                            <h5 style="font-size: .90rem; margin : 5px;text-align: left;">Billing Address: {{ $data->billing_address}}</h5>
                                        </div>
                                    </td>

                                    <td colspan="2" class="" style="border :0px solid #dee2e6 ;width:80%;"></td>
                                    <td colspan="2" class="" style="border :0px solid #dee2e6 ;"></td>
                                </tr>
                                
                            </tbody>
                            
                        </table>

                        <br>
                    
                    <div class="row overflow">
                        <table style="width: 100%;border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th  style="border: 1px solid #dee2e6!important; padding: 0 15px;">#</th>
                                    <th  style="border: 1px solid #dee2e6!important; padding: 0 15px;">Product/Service Name</th>
                                    <th  style="border: 1px solid #dee2e6!important; padding: 0 15px;">Description</th>
                                    <th  style="border: 1px solid #dee2e6!important; padding: 0 15px;">Qty</th>
                                    <th  style="border: 1px solid #dee2e6!important; padding: 0 15px;">Price</th>
                                    <th  style="border: 1px solid #dee2e6!important; padding: 0 15px;">Vat Amount</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($data->invoicedetail as $key => $invoicedtl)
                                <tr style="border-bottom:1px solid #dee2e6 ; border-right:1px solid #dee2e6 ; border-left:1px solid #dee2e6 ;">
                                    <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:center">{{ $key + 1 }}</td>
                                    <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;">{{$invoicedtl->product}} </td>
                                    <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;">{{$invoicedtl->description}}  </td>
                                    <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:center">{{$invoicedtl->quantity}} </td>
                                    <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:right">{{ number_format($invoicedtl->unit_rate, 2) }}</td>
                                    <td style="border: 1px solid #dee2e6!important; padding: 1px 10px;text-align:right">{{ number_format($invoicedtl->vat, 2) }}</td>
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

                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Discount</td>
                                    <td style="text-align:right">{{ $data->discount}}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Total</td>
                                    <td style="text-align:right">{{ $data->total}}</td>
                                </tr>

                            </tbody>
                            <tfoot  style="border :1px solid #dee2e6 ; width: 100%; ">
                                

                               

                                



                            </tfoot>
                        </table>
                    </div><br><br>

                    <div class="row overflow">
                        <table style="width: 100%;border-collapse: collapse;">
                            
                            <tbody>
                                
                                

                                <tr>
                                    <td>Company Name:</td>
                                    <td>{{ $data->company_name}}</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Acct. No</td>
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
                                    <td>SortCode:</td>
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

