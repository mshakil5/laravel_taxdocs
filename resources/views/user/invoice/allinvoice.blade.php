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
@php
    $invnumber = \App\Models\Invoice::orderby('id','DESC')->limit(1)->first();
    if (isset($invnumber)) {
        $newinv = 1001 + $invnumber->id;
    } else {
        $newinv = 1000 + 1;
    }

    $bankinfo = \App\Models\BankAccountDetail::where('user_id',Auth::user()->id)->where('status',1)->first();

@endphp
<div class="dashboard-content">

    <section class="profile purchase-status px-4">

        <div class="title-section">
            <span class="iconify" data-icon="clarity:heart-solid"></span>
            <div class="mx-2"> Invoice Information</div>
        </div>

        <button class="text-white btn-theme ml-1 mt-3" id="newBtn"> Add New </button>

    </section>  

    <section class="profile purchase-status px-4" id="addThisFormContainer">
        <div class="title-section row mt-3">
            <div class="col-md-12">
                <div class="ermsg"></div>
                <div class="col-md-12 text-muted bg-white ">
                        <div class="row mb-3">
                            <div class="col-md-6 ">
                                <label> Name<span style="color: red">*</span></label>
                                <input type="text" placeholder="Name" id="name" name="name"  class="form-control" >
                            </div>
                            
                            <div class="col-md-6 ">
                                <label> Email<span style="color: red">*</span></label>
                                <input type="email" id="email" name="email" class="form-control" >
                            </div>

                            <div class="col-md-12 ">
                                <label> Address <span style="color: red">*</span></label>
                                <input type="text" placeholder="Address" id="address" name="address" class="form-control" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 my-2">
                                <button class="text-white btn-theme ml-1" id="adduserBtn" type="submit"> Submit </button>
                                <button class="text-white btn btn-warning ml-1" id="FormCloseBtn"> Close </button>
                            </div>
                        </div>
                </div>
            </div>
        </div>

    </section>

    <section class="profile purchase-status px-4">
        <div class="title-section row mt-3">
            <div class="col-md-12">
                <div class="invermsg"></div>
                <div class="col-md-12 text-muted bg-white ">
                        <div class="row mb-3">

                            <div class="col-md-4 ">
                                <label> Invoice Number</label>
                                <input type="number" id="invoiceid" name="invoiceid" class="form-control" value="{{$newinv}}" readonly>
                                <label> Invoice Date</label>
                                <input type="date" id="invoice_date" name="invoice_date" class="form-control" value="{{date('Y-m-d')}}">

                                <label> Terms</label>
                                <input type="text" id="terms" name="terms" class="form-control" >

                                <label> Invoice To</label>
                                <select name="user_name" id="user_name" class="form-control select2" >
                                    <option value="">Select</option>
                                    @foreach (\App\Models\NewUser::where('user_id', Auth::user()->id)->get() as $nuser)
                                    <option value="{{$nuser->id}}">{{$nuser->name}}</option>
                                    @endforeach
                                </select>

                                <label> Email</label>
                                <input type="email" id="useremail" name="useremail" class="form-control" >
                                <input type="hidden" id="new_user_id" name="new_user_id" class="form-control" >

                                <label>Billing Address </label>
                                <input type="text" placeholder="Address" id="useraddress" name="useraddress" class="form-control" >
                            </div>
                            <div class="col-md-4 ">

                                <label> Select Logo</label>
                                <input type="file" id="image" name="image" class="form-control" onchange="readURL(this);" />
                                <img id="blah" src="{{ asset('images/company/'.\App\Models\CompanyDetail::where('id',1)->first()->header_logo)}}" alt="Logo" width="270px" />

                                <label> Company Name</label>
                                <input type="text" id="company_name" name="company_name" class="form-control" value="{{Auth::user()->bname}}">

                                <label> Vat no </label>
                                <input type="text" id="company_vatno" name="company_vatno" class="form-control">

                                <label> Tell No</label>
                                <input type="text" id="company_tell_no" name="company_tell_no" class="form-control" value="{{Auth::user()->phone}}">

                                <label>Company Email </label>
                                <input type="text" id="company_email" name="company_email" class="form-control" value="{{Auth::user()->email}}">
                                
                            </div>
                            <div class="col-md-4 ">
                                <label> Acct No</label>
                                <input type="text" id="acct_no" name="acct_no" class="form-control" value="{{$bankinfo->bank_acc_number}}">

                                <label> Bank </label>
                                <input type="text" id="bank" name="bank" class="form-control">

                                <label> Sort-Code</label>
                                <input type="text" id="short_code" name="short_code" class="form-control" value="{{$bankinfo->bank_acc_sort_code}}">

                            </div>

                        </div>

                        <div class="row">

                            {{-- new  --}}
                            <div class="data-container">
                                <table class="table table-theme mt-0">
                                    <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Product/Services</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Vat</th>

                                        </tr>
                                    </thead>
                                    <tbody id="inner">

                                            <tr class="item-row" style="position:realative;">
                                                <td class="px-1">
                                                    <div style="color: white;  user-select:none;  padding: 5px;    background: red;    width: 45px;    display: flex;    align-items: center; margin-right:5px;   justify-content: center;    border-radius: 4px;   left: 4px;    top: 8px;" onclick="removeRow(event)" >X</div>
                                                </td>
                                                <td class="px-1">
                                                    <input class="form-control" name="product_name[]" type="text">
                                                </td>
                                                <td class="fs-16 txt-secondary px-1">
                                                    <input class="form-control" name="description[]" type="text">
                                                </td>
                                                <td class="fs-16 txt-secondary px-1">
                                                    <input style="min-width: 50px;"  type="number" name="quantity[]" class="form-control quantity" value="1" min="1">
                                                </td>

                                                <td class="fs-16 txt-secondary px-1">
                                                    <input style="min-width: 50px;"  type="number" name="unit_rate[]" class="form-control rate" value="0" min="0">
                                                </td>

                                                <td class="fs-16 txt-secondary px-1">
                                                    <input style="min-width: 50px;"  type="number" name="amount[]" class="form-control amount" value="0" min="0">
                                                </td>

                                                <td class="fs-16 txt-secondary px-1">
                                                    <input style="min-width: 50px;"  type="number" name="vat[]" class="form-control vat" value="0" min="0">
                                                </td>

                                                
                                            </tr>
                                            

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
                                <textarea name="invmessg" id="invmessg" cols="30" rows="5" class="form-control"></textarea>
                                
                                
                               
                                
                            </div>
                            <div class="col-md-4 ">
                            </div>
                            <div class="col-md-4 ">
                                <table style="width: 100%">
                                    <tbody>
                                        <tr>
                                            <td style="text-align: left">Subtotal: </td>
                                            <td style="text-align: left;width: 108px;" class="">
                                                <input type="text"  name="subtotal" id="subtotal" class="form-control" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left">Vat: </td>
                                            <td style="text-align: left;width: 108px;" class="">
                                                <input type="text"  name="totalvat" id="totalvat" class="form-control" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left">Discount: </td>
                                            <td style="text-align: left;width: 108px;" class="">
                                                <input type="text"  name="discount" id="discount" value="0" class="form-control">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left">Total: </td>
                                            <td style="text-align: left;width: 108px;" class="">
                                                <input type="text"  name="totalamount" id="totalamount" class="form-control" readonly>
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
                                

                                {{-- <button type="button" class="text-white btn-theme ml-1 btn-block " id="">Save as .xlsx </button> --}}
                                <button type="button" class="text-white btn-theme ml-1 btn-block savePdfBtn" id="savePdfBtn">Save as pdf </button>
                                <button type="button" class="text-white btn-theme ml-1 btn-block"  id="saveinvBtn">Email as pdf </button>
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

<script>
    net_total(); 
    function removeRow(event) {
        event.target.parentElement.parentElement.remove();
        net_total(); 
    }

    function net_total(){
            var grand_total=0;
            $('.amount').each(function(){
                grand_total += ($(this).val()-0);
            })

            var vatamnt = 0;
            $('.vat').each(function(){
                vatamnt += ($(this).val()-0);
            })
            var discount = $("#discount").val();
            
            $("#subtotal").val(grand_total);
            $("#totalvat").val(vatamnt);
            var totalamount = grand_total + vatamnt - discount;
            $("#totalamount").val(totalamount);


        }


    $(document).ready(function () {
        
        $(".add-row").click(function() {
            var markup =
                '<tr class="item-row" style="position:realative"><td class="px-1"><div style="color:#fff;user-select:none;padding:5px;background:red;width:45px;display:flex;align-items:center;margin-right:5px;justify-content:center;border-radius:4px;left:4px;top:8px" onclick="removeRow(event)">X</div></td><td class="px-1"><input class="form-control" name="product_name[]" type="text"></td><td class="fs-16 txt-secondary px-1"><input class="form-control" name="description[]"></td><td class="fs-16 txt-secondary px-1"><input style="min-width:50px" type="number" name="quantity[]" class="form-control quantity" value="1" min="1"></td><td class="fs-16 txt-secondary px-1"><input style="min-width:50px" type="number" name="unit_rate[]" class="form-control rate" value="0" min="0"></td><td class="fs-16 txt-secondary px-1"><input style="min-width:50px" type="number" name="amount[]" class="form-control amount" value="0" min="0"></td><td class="fs-16 txt-secondary px-1"><input style="min-width:50px" type="number" name="vat[]" class="form-control vat" value="0" min="0"></td></tr>';

            $("table #inner").append(markup);
        });

        $("#addThisFormContainer").hide();
        $("#newBtn").click(function(){
            $("#newBtn").hide(100);
            $("#addThisFormContainer").show(300);

        });
        $("#FormCloseBtn").click(function(){
            $("#addThisFormContainer").hide(200);
            $("#newBtn").show(100);
        });
        //header for csrf-token is must in laravel
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        //
        // submit to payrollurl 
        var newuserurl = "{{URL::to('/user/new-user')}}";

            $("body").delegate("#adduserBtn","click",function(event){
                event.preventDefault();

                var name = $("#name").val();
                var email = $("#email").val();
                var address = $("#address").val();
                

                $.ajax({
                    url: newuserurl,
                    method: "POST",
                    data: {name,email,address},

                    success: function (d) {
                        if (d.status == 303) {
                            $(".ermsg").html(d.message);
                            pagetop();
                        }else if(d.status == 300){
                            $(".ermsg").html(d.message);
                            pagetop();
                            $("#addThisFormContainer").hide();
                            
                            $("#new_user_id").val(d.data.id);
                            $("#username").val(d.data.name);
                            $("#useraddress").val(d.data.address);
                            $("#useremail").val(d.data.email);
                            // window.setTimeout(function(){location.reload()},2000)
                            
                        }
                    },
                    error: function (d) {
                        console.log(d);
                    }
                });

        });
        // submit to purchase end

        // customer destails 

        var getuserurl = "{{URL::to('/user/get-new-users')}}";
        $("#user_name").change(function(){
                event.preventDefault();
                var uid = $(this).val();
                $.ajax({
                url: getuserurl,
                method: "POST",
                data: {uid:uid},

                success: function (d) {
                    if (d.status == 303) {

                    }else if(d.status == 300){
                        $("#new_user_id").val(d.user_id);
                        $("#username").val(d.username);
                        $("#useraddress").val(d.address);
                        $("#useremail").val(d.useremail);
                        
                    }
                },
                error: function (d) {
                    console.log(d);
                }
            });

        });


        // unit price calculation
        $("body").delegate(".quantity, .rate, .amount, .vat","keyup",function(event){
            event.preventDefault();
            var row = $(this).parent().parent();
            var quantity = parseInt(row.find('.quantity').val());
            var rate = parseInt(row.find('.rate').val());
            var amount = quantity * rate;
            row.find('.amount').val(amount);
            net_total();
        })
        // unit price calculation end

        // unit price calculation

        $("body").delegate("#discount","keyup",function(event){
            event.preventDefault();
            var subtotal = $("#subtotal").val();
            var totalvat = $("#totalvat").val();
            var discount = $("#discount").val();
            var totalamount = subtotal + totalvat - discount;
            $("#totalamount").val(totalamount);
            net_total();
        })
        // unit price calculation end
        

        $(document).on('click', '.savebtn', function () {
            var useremail = $("#useremail").val();
            $('#myModal').find('.modal-body #tomail').val(useremail);
        });


        var invoiceurl = "{{URL::to('/user/invoice')}}";
        $("body").delegate("#saveinvBtn","click",function(event){
                event.preventDefault();

                var image = $('#image').prop('files')[0];
                    if(typeof image === 'undefined'){
                        image = 'null';
                    }
                
                var form_data = new FormData();
                form_data.append('image', image);
                form_data.append("user_name", $("#user_name").val());
                form_data.append("useremail", $("#useremail").val());
                form_data.append("new_user_id", $("#new_user_id").val());
                form_data.append("useraddress", $("#useraddress").val());
                form_data.append("terms", $("#terms").val());
                form_data.append("invoice_date", $("#invoice_date").val());
                form_data.append("due_date", $("#due_date").val());
                form_data.append("invmessg", $("#invmessg").val());
                form_data.append("appointmentmessg", $("#appointmentmessg").val());
                form_data.append("tomail", $("#tomail").val());
                form_data.append("subjectmail", $("#subjectmail").val());
                form_data.append("mailbody", $("#mailbody").val());
                form_data.append("subtotal", $("#subtotal").val());
                form_data.append("totalamount", $("#totalamount").val());
                form_data.append("balancedue", $("#balancedue").val());
                form_data.append("invoiceid", $("#invoiceid").val());
                form_data.append("totalvat", $("#totalvat").val());
                form_data.append("discount", $("#discount").val());

                form_data.append("company_name", $("#company_name").val());
                form_data.append("company_vatno", $("#company_vatno").val());
                form_data.append("company_tell_no", $("#company_tell_no").val());
                form_data.append("company_email", $("#company_email").val());
                form_data.append("acct_no", $("#acct_no").val());
                form_data.append("bank", $("#bank").val());
                form_data.append("short_code", $("#short_code").val());

                var product_name = $("input[name='product_name[]']")
                    .map(function(){return $(this).val();}).get();

                var description = $("input[name='description[]']")
                    .map(function(){return $(this).val();}).get();

                var quantity = $("input[name='quantity[]']")
                    .map(function(){return $(this).val();}).get();

                var unit_rate = $("input[name='unit_rate[]']")
                    .map(function(){return $(this).val();}).get();

                var amount = $("input[name='amount[]']")
                    .map(function(){return $(this).val();}).get();
                    
                var vat = $("input[name='vat[]']")
                    .map(function(){return $(this).val();}).get();

                    form_data.append('product_name', product_name);
                    form_data.append('description', description);
                    form_data.append('quantity', quantity);
                    form_data.append('unit_rate', unit_rate);
                    form_data.append('amount', amount);
                    form_data.append('vat', vat);

                    console.log(product_name)

                $.ajax({
                      url: invoiceurl,
                      method: "POST",
                      contentType: false,
                      processData: false,
                      data:form_data,
                      success: function (d) {
                            console.log(d);
                          if (d.status == 303) {
                                $(".invermsg").html(d.message);
                          }else if(d.status == 300){
                                $(".invermsg").html(d.message);
                                pagetop();
                                window.setTimeout(function(){location.reload()},2000)
                          }
                      },
                      error: function (d) {
                          console.log(d);
                      }
                  });

        });


        var invoicepdfurl = "{{URL::to('/user/invoice-pdf')}}";
        $("body").delegate("#savePdfBtn","click",function(event){
                event.preventDefault();

                var image = $('#image').prop('files')[0];
                    if(typeof image === 'undefined'){
                        image = 'null';
                    }
                
                var form_data = new FormData();
                form_data.append('image', image);
                form_data.append("user_name", $("#user_name").val());
                form_data.append("useremail", $("#useremail").val());
                form_data.append("new_user_id", $("#new_user_id").val());
                form_data.append("useraddress", $("#useraddress").val());
                form_data.append("terms", $("#terms").val());
                form_data.append("invoice_date", $("#invoice_date").val());
                form_data.append("due_date", $("#due_date").val());
                form_data.append("invmessg", $("#invmessg").val());
                form_data.append("appointmentmessg", $("#appointmentmessg").val());
                form_data.append("tomail", $("#tomail").val());
                form_data.append("subjectmail", $("#subjectmail").val());
                form_data.append("mailbody", $("#mailbody").val());
                form_data.append("subtotal", $("#subtotal").val());
                form_data.append("totalamount", $("#totalamount").val());
                form_data.append("balancedue", $("#balancedue").val());
                form_data.append("invoiceid", $("#invoiceid").val());
                form_data.append("totalvat", $("#totalvat").val());
                form_data.append("discount", $("#discount").val());

                form_data.append("company_name", $("#company_name").val());
                form_data.append("company_vatno", $("#company_vatno").val());
                form_data.append("company_tell_no", $("#company_tell_no").val());
                form_data.append("company_email", $("#company_email").val());
                form_data.append("acct_no", $("#acct_no").val());
                form_data.append("bank", $("#bank").val());
                form_data.append("short_code", $("#short_code").val());

                var product_name = $("input[name='product_name[]']")
                    .map(function(){return $(this).val();}).get();

                var description = $("input[name='description[]']")
                    .map(function(){return $(this).val();}).get();

                var quantity = $("input[name='quantity[]']")
                    .map(function(){return $(this).val();}).get();

                var unit_rate = $("input[name='unit_rate[]']")
                    .map(function(){return $(this).val();}).get();

                var amount = $("input[name='amount[]']")
                    .map(function(){return $(this).val();}).get();
                    
                var vat = $("input[name='vat[]']")
                    .map(function(){return $(this).val();}).get();

                    form_data.append('product_name', product_name);
                    form_data.append('description', description);
                    form_data.append('quantity', quantity);
                    form_data.append('unit_rate', unit_rate);
                    form_data.append('amount', amount);
                    form_data.append('vat', vat);

                    console.log(product_name)

                $.ajax({
                      url: invoicepdfurl,
                      method: "POST",
                      contentType: false,
                      processData: false,
                      data:form_data,
                      success: function (d) {
                            console.log(d);
                          if (d.status == 303) {
                                $(".invermsg").html(d.message);
                          }else if(d.status == 300){
                                $(".invermsg").html(d.message);
                                pagetop();
                                window.open(`https://www.taxdocs.co.uk/user/invoice/${d.id}`, '_blank');
                                // window.setTimeout(function(){location.reload()},2000)
                          }
                      },
                      error: function (d) {
                          console.log(d);
                      }
                  });

        });

        

    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(270)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    };

</script>

@endsection
