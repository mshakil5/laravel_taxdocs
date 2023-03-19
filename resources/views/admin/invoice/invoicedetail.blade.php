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


            <section class="profile purchase-status px-4">
                <div class="title-section row mt-3">
                    <div class="col-md-12">
                        <div class="invermsg"></div>
                        <div class="col-md-12 text-muted bg-white ">
                                <div class="row mb-3">
        
                                    <div class="col-md-4 ">
                                        <label> Invoice Number</label>
                                        <input type="number" id="invoiceid" name="invoiceid" class="form-control" value="{{$data->invoiceid}}" readonly>
                                        <input type="hidden" id="dataid" name="dataid" class="form-control" value="{{$data->id}}">
                                        <label> Invoice Date</label>
                                        <input type="date" id="invoice_date" name="invoice_date" class="form-control" value="{{$data->invoice_date}}">
        
                                        <label> Terms</label>
                                        <input type="text" id="terms" name="terms" class="form-control" value="{{$data->terms}}">
        
                                        <label> Invoice To</label>
                                        <select name="user_name" id="user_name" class="form-control select2" >
                                            <option value="">Select</option>
                                            @foreach (\App\Models\NewUser::where('user_id', Auth::user()->id)->get() as $nuser)
                                            <option value="{{$nuser->id}}" @if ($nuser->id == $data->user_name) selected @endif>{{$nuser->name}}</option>
                                            @endforeach
                                        </select>
        
                                        <label> Email</label>
                                        <input type="email" id="useremail" name="useremail" class="form-control" value="{{$data->email}}">
                                        <input type="hidden" id="new_user_id" name="new_user_id" class="form-control" value="{{$data->new_user_id}}" >
        
                                        <label>Billing Address </label>
                                        <input type="text" placeholder="Address" id="useraddress" name="useraddress" class="form-control" value="{{$data->billing_address}}" >
                                    </div>
                                    <div class="col-md-4 ">
        
                                        <label> Select Logo</label>
                                        <input type="file" id="image" name="image" class="form-control" onchange="readURL(this);" />
                                        <img id="blah" src="{{ asset('images/'.$data->image)}}" alt="Logo" width="270px" />
        
                                        <label> Company Name</label>
                                        <input type="text" id="company_name" name="company_name" class="form-control" value="{{$data->company_name}}">
        
                                        <label> Vat no </label>
                                        <input type="text" id="company_vatno" name="company_vatno" class="form-control" value="{{$data->company_vatno}}">
        
                                        <label> Tell No</label>
                                        <input type="text" id="company_tell_no" name="company_tell_no" class="form-control" value="{{$data->company_tell_no}}">
        
                                        <label>Company Email </label>
                                        <input type="text" id="company_email" name="company_email" class="form-control" value="{{$data->company_email}}">
                                        
                                    </div>
                                    <div class="col-md-4 ">
                                        <label> Acct No</label>
                                        <input type="text" id="acct_no" name="acct_no" class="form-control" value="{{$data->acct_no}}">
        
                                        <label> Bank </label>
                                        <input type="text" id="bank" name="bank" class="form-control" value="{{$data->bank}}">
        
                                        <label> Sort-Code</label>
                                        <input type="text" id="short_code" name="short_code" class="form-control" value="{{$data->short_code}}">
        
                                    </div>
        
                                </div>
        
                                <div class="row">
        
                                    {{-- new  --}}
                                    <div class="data-container">
                                        <table class="table table-theme mt-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col"></th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Qty</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Amount</th>
                                                    <th scope="col">Vat</th>
        
                                                </tr>
                                            </thead>
                                            <tbody id="inner">
        
                                                @foreach ($data->invoicedetail as $invdtl)
                                                <tr class="item-row" style="position:realative;">
                                                    <td class="px-1">
                                                    </td>
                                                    <td class="fs-16 txt-secondary px-1">
                                                        <input class="form-control" name="description[]" type="text" value="{{$invdtl->description}}">
                                                        <input class="form-control" name="invdtlid[]" type="hidden" value="{{$invdtl->id}}">
                                                    </td>
                                                    <td class="fs-16 txt-secondary px-1">
                                                        <input style="min-width: 50px;"  type="number" name="quantity[]" class="form-control quantity" value="{{$invdtl->quantity}}" min="1">
                                                    </td>
                                                    <td class="fs-16 txt-secondary px-1">
                                                        <input style="min-width: 50px;"  type="number" name="unit_rate[]" class="form-control rate" value="{{$invdtl->unit_rate}}" min="0">
                                                    </td>
                                                    <td class="fs-16 txt-secondary px-1">
                                                        <input style="min-width: 50px;"  type="number" name="amount[]" class="form-control amount" value="{{$invdtl->amount}}" min="0">
                                                    </td>
                                                    <td class="fs-16 txt-secondary px-1">
                                                        <input style="min-width: 50px;"  type="number" name="vat[]" class="form-control vat" value="{{$invdtl->vat}}" min="0">
                                                    </td>
                                                </tr>
                                                @endforeach
        
                                                    
                                                    
        
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
        
                                <div class="row mb-3">
        
                                    <div class="col-md-4 ">
                                        <label> Message on Invoice</label>
                                        <textarea name="invmessg" id="invmessg" cols="30" rows="5" class="form-control">{{ $data->message_on_invoice}}</textarea>
                                        
                                        
                                       
                                        
                                    </div>
                                    <div class="col-md-4 ">
                                    </div>
                                    <div class="col-md-4 ">
                                        <table style="width: 100%">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: left">Subtotal: </td>
                                                    <td style="text-align: left;width: 108px;" class="">
                                                        <input type="text"  name="subtotal" id="subtotal" class="form-control" value="{{$data->subtotal}}" readonly>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left">Vat: </td>
                                                    <td style="text-align: left;width: 108px;" class="">
                                                        <input type="text"  name="totalvat" id="totalvat" class="form-control" value="{{$data->vat}}" readonly>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left">Discount: </td>
                                                    <td style="text-align: left;width: 108px;" class="">
                                                        <input type="text"  name="discount" id="discount" value="0" class="form-control" value="{{$data->discount}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left">Total: </td>
                                                    <td style="text-align: left;width: 108px;" class="">
                                                        <input type="text"  name="totalamount" id="totalamount" class="form-control"  value="{{$data->total}}" readonly>
                                                    </td>
                                                </tr>
                                                
        
                                            </tbody>
                                        </table>
                                    </div>
        
        
                                </div>
        
                                <div class="row mb-3">
        
                                    <div class="col-md-4 ">
                                        
                                        
                                    </div>
                                    <div class="col-md-4 ">
                                    </div>
                                    <div class="col-md-4 ">
                                        
                                        
        
                                    </div>
        
        
                                </div>
          
                        </div>
                    </div>
                </div>
            </section>

        </div>


    </main>

@endsection
@section('script')
<script>
$(document).ready(function() {
    var table = $('#example').DataTable( {
        responsive: true,
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
    } );

    
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
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
