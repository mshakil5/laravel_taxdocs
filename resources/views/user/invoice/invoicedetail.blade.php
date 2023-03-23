@extends('layouts.user')
@section('content')


<style>
    .pl25{
        padding-left: 25px;
    }
</style>
<style>
    article, aside, figure, footer, header, hgroup, 
    menu, nav, section { display: block; }
</style>
<div class="dashboard-content">

    <section class="profile purchase-status px-4">
        <div class="title-section">
            <span class="iconify" data-icon="clarity:heart-solid"></span>
            <div class="mx-2"> Invoice Information</div>
        </div>
    </section>  



    <section class="profile purchase-status px-4">
        <div class="title-section row mt-3">
            <div class="col-md-12">
                <div class="invermsg"></div>
                <div class="col-md-12 text-muted bg-white ">
                        <div class="row mb-3">

                            <div class="col-md-4 ">
                                <label> Invoice Date</label>
                                <input type="date" id="invoice_date" name="invoice_date" class="form-control" value="{{$data->invoice_date}}">
                            </div>
                            <div class="col-md-4 ">
                                <label> Email</label>
                                <input type="email" id="useremail" name="useremail" class="form-control" value="{{$data->email}}">
                                <input type="hidden" id="new_user_id" name="new_user_id" class="form-control" value="{{$data->new_user_id}}" >
                                
                            </div>
                            <div class="col-md-4 ">
                                <label>Billing Address </label>
                                <input type="text" placeholder="Address" id="useraddress" name="useraddress" class="form-control" value="{{$data->billing_address}}" >
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
                                            <th scope="col">Vat</th>
                                            <th scope="col">Total (exc VAT)</th>

                                        </tr>
                                    </thead>
                                    <tbody id="inner">

                                        @foreach ($data->invoicedetail as $invdtl)
                                        <tr class="item-row" style="position:realative;">
                                            <td class="px-1">
                                            </td>
                                            <td class="fs-16 txt-secondary px-1">
                                                <input class="form-control" name="description[]" type="text" value="{{$invdtl->description}}">
                                            </td>
                                            <td class="fs-16 txt-secondary px-1">
                                                <input style="min-width: 50px;"  type="number" name="quantity[]" class="form-control quantity" value="{{$invdtl->quantity}}" min="1">
                                            </td>
                                            <td class="fs-16 txt-secondary px-1">
                                                <input style="min-width: 50px;"  type="number" name="unit_rate[]" class="form-control rate" value="{{$invdtl->unit_rate}}" min="0">
                                            </td>
                                            <td class="fs-16 txt-secondary px-1">
                                                <input style="min-width: 50px;"  type="number" name="vat[]" class="form-control vat" value="{{$invdtl->vat}}" min="0">
                                            </td>
                                            <td class="fs-16 txt-secondary px-1">
                                                <input style="min-width: 50px;"  type="number" name="amount[]" class="form-control amount" value="{{$invdtl->amount}}" min="0">
                                            </td>
                                        </tr>
                                        @endforeach

                                            
                                            

                                    </tbody>
                                    <tfoot>
                                       
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
                                
                                {{-- <button type="button" class="text-white btn-theme ml-1 btn-block" id="updateBtn">Update </button> --}}
                                {{-- <button type="button" class="text-white btn-theme ml-1 btn-block " id="">Save as .xlsx </button> --}}
                                {{-- <button type="button" class="text-white btn-theme ml-1 btn-block savePdfBtn" id="savePdfBtn">Save as pdf </button> --}}
                                {{-- <button type="button" class="text-white btn-theme ml-1 btn-block"  id="saveinvBtn">Email as pdf </button> --}}
                                {{-- <button type="button" class="text-white btn-theme ml-1 btn-block">Add to record </button>
                                <button type="button" class="text-white btn-theme ml-1 btn-block">Start new Inv </button> --}}

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
    $(document).ready(function() {
        // Select2 Multiple
        $('.select2').select2({
            placeholder: "Select",
            allowClear: true
        });
    });

</script>


@endsection
