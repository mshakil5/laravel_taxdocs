@extends('layouts.user')
@section('content')


<div class="dashboard-content">
  <section class=""> 
    <div class="row  my-3 mx-0 "> 
        <div class="col-md-12 ">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <button class="nav-link active" id="transactionOut-tab" data-bs-toggle="tab" data-bs-target="#nav-transactionOut" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Image</button>
                  <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-transcationIn" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Details</button>
                  <button class="nav-link" id="nav-password-tab" data-bs-toggle="tab" data-bs-target="#nav-password" type="button" role="tab" aria-controls="nav-password" aria-selected="false">Change Password</button>
                  <button class="nav-link" id="nav-bank-tab" data-bs-toggle="tab" data-bs-target="#nav-bank" type="button" role="tab" aria-controls="nav-password" aria-selected="false">Bank Details</button>

                </div>
              </nav>
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-transactionOut" role="tabpanel" aria-labelledby="nav-transactionOut">
                    <div class="row my-2">
                        
                      <div class="col-md-12 ">
                        <div class="row mx-auto">
                            <div class="col-md-6 border-right">
                                <div class="ermsg"></div>
                                <div class="d-flex flex-column align-items-center text-center p-3 py-5" style="position:relative">

                                    @if (isset(Auth::user()->photo))
                                    <img class="rounded-circle mt-5" width="350px" src="{{asset('images/'.Auth::user()->photo)}}">
                                    @else
                                    <img class="rounded-circle mt-5" width="350px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                                        
                                    @endif

                                    <span class="font-weight-bold"><input type="file" id="pimage" name="pimage" class="form-control"></span>
                                    <span class="mt-3"><button class="btn-theme text-white imgBtn" type="button">Upload Image</button></span>
                                </div>
                            </div>


                        </div>
                    </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-transcationIn" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="row my-2">
                        
                        <div class="col-md-12 ">
                            <div class="row mx-auto">
                                <div class="col-md-6 border-right">
                                    <div class="udtlermsg"></div>
                                    <div class="p-3 py-4 text-muted">

                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label><small>Name</small></label>
                                                <input type="text" class="form-control" id="uname" name="uname" placeholder="Name" value="{{ Auth::user()->name }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label><small>Surname</small></label>
                                                <input type="text" class="form-control" id="usurname" name="usurname" placeholder="surname" value="{{ Auth::user()->surname }}">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label><small>Email</small></label>
                                                <input type="email" class="form-control" id="usremail" name="uemail" placeholder="Email" value="{{ Auth::user()->email }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label><small>Contact Number</small></label>
                                                <input type="text" class="form-control" id="ucnumber" name="ucnumber" maxlength="12" placeholder="Contact Number" value="{{ Auth::user()->phone }}">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label><small>Business Name</small></label>
                                                <input type="text" class="form-control" id="ubname" name="ubname" placeholder="Business Name" value="{{ Auth::user()->bname }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label><small>Business Address</small></label>
                                                <input type="text" class="form-control" id="ubaddress" name="ubaddress" value="{{ Auth::user()->baddress }}" placeholder="Business Address">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label><small>House Number</small></label>
                                                <input type="text" class="form-control" id="uhousenumber" name="uhousenumber" placeholder="House Number" value="{{ Auth::user()->house_number }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label><small>Street Name</small></label>
                                                <input type="text" class="form-control" id="ustreetname" name="ustreetname" value="{{ Auth::user()->street_name }}" placeholder="Street Name">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label><small>Town</small></label>
                                                <input type="text" class="form-control" id="utown" name="utown" placeholder="Town" value="{{ Auth::user()->town }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label><small>Post Code</small></label>
                                                <input type="text" class="form-control" id="upostcode" name="upostcode" value="{{ Auth::user()->postcode }}" placeholder="Post Code">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label><small>Contact Person</small></label>
                                                <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Contact Person" value="{{ Auth::user()->contact_person }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label><small>Website</small></label>
                                                <input type="text" class="form-control" id="bweb" name="bweb" value="{{ Auth::user()->bweb }}" placeholder="Website">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label><small>Registration Number</small></label>
                                                <input type="text" class="form-control" id="reg_number" name="reg_number" placeholder="Registration Number" value="{{ Auth::user()->reg_number }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label><small>Note</small></label>
                                                <input type="text" class="form-control" id="note" name="note" value="{{ Auth::user()->note }}" placeholder="Note">
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label><small>Accountant Name</small></label>
                                                <input type="text" class="form-control" id="accountant_name" name="accountant_name" value="{{ Auth::user()->accountant_name }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label><small>Subscription Plan</small></label>
                                                <input type="text" class="form-control" id="sub_plan" name="sub_plan" value="@if (Auth::user()->subscription_plan == 1) Individual Plan £5.95 @endif @if (Auth::user()->subscription_plan == 2) Business Plan £10.95 @endif">
                                            </div>
                                        </div>

                                        @php
                                            $accnumber = \App\Models\BankAccountDetail::where('user_id', Auth::user()->id)->where('status','1')->first();
                                        @endphp

                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label><small>Bank Account Number</small></label>
                                                <input type="text" class="form-control" id="bank_acc_number" name="bank_acc_number" value="{{ $accnumber->bank_acc_number }}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label><small>Bank Account Code</small></label>
                                                <input type="text" class="form-control" id="bank_acc_sort_code" name="bank_acc_sort_code" value="{{ $accnumber->bank_acc_sort_code }}" readonly>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <button class="btn-theme text-white userdetailsBtn" type="button">Update Profile</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
                <div class="tab-pane fade" id="nav-password" role="tabpanel" aria-labelledby="nav-password-tab">
                  <div class="row my-2">
                      
                    <div class="col-md-12 ">
                        <div class="row mx-auto">

                            <div class="col-md-5 border-right">
                                <div class="permsg"></div>
                                <div class="p-3 py-4 text-muted">
                                    <div class="row mt-3">
                                        <div class="col-md-12 mb-3">
                                            <label><small>Old Password</small></label>
                                            <input class="form-control" id="old_password" type="password">
                                        </div>     
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label><small>New Password</small></label>
                                            <input class="form-control" id="new_password" type="password">
                                        </div>
                                        <div class="col-md-6">
                                            <label><small>Confirm Password</small></label>
                                            <input class="form-control" id="password_confirmation" type="password">
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <button class="btn-theme text-white passwordBtn" type="button">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                
                <div class="tab-pane fade" id="nav-bank" role="tabpanel" aria-labelledby="nav-bank-tab">
                    <div class="row my-2">
                        <div class="title-section">
                            <span class="iconify" data-icon="clarity:heart-solid"></span>
                            <div class="mx-2">Bank Account Details</div>
                        </div>
                        
                      <div class="col-md-12 ">
                          <div class="row mx-auto">

                            <div class="col-md-6">
                                <div class="bankermsg"></div>
                                <div class="form-custom"> 
                                    @csrf
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label> Bank Account Number </label>
                                            <input type="text" class="form-control" id="bank_acc_number" name="bank_acc_number">
                                        </div>
                                        <div class="col-md-6">
                                            <label> Bank Account Code </label>
                                            <input type="text" class="form-control" id="bank_acc_sort_code" name="bank_acc_sort_code">
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <button type="submit" class="btn-theme bg-primary d-block text-center mx-0 text-white" id="saveBankBtn">Save</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-10" id="contentContainer">
                                <div class="bankmsg"></div>
                                <div class="bankstsmsg"></div>
                                  <div class="p-3 py-4 text-muted">
                                    <div class="data-container">
                                        <table class="table table-theme mt-4">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Bank Account Number</th>
                                                    <th scope="col">Bank Account Code </th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach (\App\Models\BankAccountDetail::where('user_id',Auth::user()->id)->get() as $bank)
                                                <tr>
                                                    <td class="fs-20 txt-secondary fw-bold">{{ $bank->created_at }}</td>
                                                    <td><span class="fs-16 txt-secondary">{{ $bank->bank_acc_number }}</span></td>
                                                    <td class="fs-16 txt-secondary">{{ $bank->bank_acc_sort_code }}</td>
                                                    <td class="fs-16 txt-secondary">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked"  data-id="{{$bank->id}}" {{ $bank->status ? 'checked' : '' }}>
                                                        </div>
                                                    </td>

                                                    <td class="fs-16 txt-secondary">
                                                        @if ($bank->status == 1)
                                                        @else
                                                        <a id="deleteBtn" rid="{{$bank->id}}">
                                                            <div class="d-flex flex-column">
                                                                <div class="fs-16 txt-primary d-flex">
                                                                    <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M4.05 10.375L6 8.425L7.95 10.375L9 9.325L7.05 7.375L9 5.425L7.95 4.375L6 6.325L4.05 4.375L3 5.425L4.95 7.375L3 9.325L4.05 10.375ZM2.25 13.75C1.8375 13.75 1.4845 13.6033 1.191 13.3098C0.897 13.0158 0.75 12.6625 0.75 12.25V2.5H0V1H3.75V0.25H8.25V1H12V2.5H11.25V12.25C11.25 12.6625 11.1033 13.0158 10.8098 13.3098C10.5158 13.6033 10.1625 13.75 9.75 13.75H2.25ZM9.75 2.5H2.25V12.25H9.75V2.5Z" fill="#18988B" />
                                                                    </svg>
                                                                    <span class="ms-2">Delete</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        {{-- <a id="deleteBtn" rid="{{$bank->id}}"><i class="fa fa-trash-o" style="color: red;font-size:16px;"></i></a> --}}
                                                            
                                                        @endif
                                                    </td>
                                                </tr> 
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
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
    $(function() {
      $('.form-check-input').change(function() {
        var activeurl = "{{URL::to('/user/active-account')}}";
          var status = $(this).prop('checked') == true ? 1 : 0;
          var id = $(this).data('id');
           console.log(status);
          $.ajax({
              type: "GET",
              dataType: "json",
              url: activeurl,
              data: {'status': status, 'id': id},
              success: function(d){
                // console.log(data.success)
                if (d.status == 303) {
                            $(".bankstsmsg").html(d.message);
                    }else if(d.status == 300){
                            $(".bankstsmsg").html(d.message);
                        window.setTimeout(function(){location.reload()},2000)
                    }
                },
                error: function (d) {
                    console.log(d);
                }
          });
      })
    })
  </script>

<script>
  $(document).ready(function(){
      //header for csrf-token is must in laravel
      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
      //
      var url = "{{URL::to('/user/profile-update')}}";
      //console.log(url);
      $(".userdetailsBtn").click(function(){
          var form_data = new FormData();
        form_data.append("name", $("#uname").val());
        form_data.append("surname", $("#usurname").val());
        form_data.append("email", $("#usremail").val());
        form_data.append("phone", $("#ucnumber").val());
        form_data.append("bname", $("#ubname").val());
        form_data.append("baddress", $("#ubaddress").val());
        form_data.append("house_number", $("#uhousenumber").val());
        form_data.append("street_name", $("#ustreetname").val());
        form_data.append("town", $("#utown").val());
        form_data.append("postcode", $("#upostcode").val());
        form_data.append("contact_person", $("#contact_person").val());
        form_data.append("bweb", $("#bweb").val());
        form_data.append("reg_number", $("#reg_number").val());
        form_data.append("note", $("#note").val());

        //   console.log(email);
            $.ajax({
                    url:url,
                    method: "POST",
                    contentType: false,
                    processData: false,
                    data:form_data,
                    success: function (d) {
                    console.log(d);
                        if (d.status == 303) {
                            $(".udtlermsg").html(d.message);
                        }else if(d.status == 300){
                        pagetop();
                            $(".udtlermsg").html(d.message);
                        }
                    },
                    error: function (d) {
                        console.log(d);
                    }
                });
      });

      var passwordurl = "{{URL::to('/user/changepassword')}}";
            $(".passwordBtn").click(function(){
                //alert('btn work');
                var password= $("#new_password").val();
                var confirmpassword= $("#password_confirmation").val();
                var opassword= $("#old_password").val();
                // console.log(password);
                $.ajax({
                    url: passwordurl,
                    method: "POST",
                    data: {password:password,confirmpassword:confirmpassword,opassword:opassword},
                    success: function (d) {
                        console.log(d);
                        if (d.status == 303) {
                            $(".permsg").html(d.message);
                        }else if(d.status == 300){
                            pagetop();
                            $(".permsg").html(d.message);
                        }
                    },
                    error: function (d) {
                        console.log(d);
                    }
                });
            });


            //image upload

            var imgurl = "{{URL::to('/user/image')}}";
            $(".imgBtn").click(function(){
              var file_data = $('#pimage').prop('files')[0];
                  if(typeof file_data === 'undefined'){
                    file_data = 'null';
                  }
                  var form_data = new FormData();
                  form_data.append('image', file_data);
                //   form_data.append('_method', 'put');

                    $.ajax({
                      url:imgurl,
                      method: "POST",
                      contentType: false,
                      processData: false,
                      data:form_data,
                      success: function (d) {
                          if (d.status == 303) {
                              $(".ermsg").html(d.message);
                          }else if(d.status == 300){
                            pagetop();
                              $(".ermsg").html(d.message);
                            window.setTimeout(function(){location.reload()},2000)
                          }
                      },
                      error: function (d) {
                          console.log(d);
                      }
                  });
                //create  end
            });

            
        var bankurl = "{{URL::to('/user/bank-account')}}";

        $("#saveBankBtn").click(function(){
            // alert('work');

        var form_data = new FormData();
        form_data.append("bank_acc_number", $("#bank_acc_number").val());
        form_data.append("bank_acc_sort_code", $("#bank_acc_sort_code").val());

            $.ajax({
                    url:bankurl,
                    method: "POST",
                    contentType: false,
                    processData: false,
                    data:form_data,
                    success: function (d) {
                    console.log(d);
                        if (d.status == 303) {
                            $(".bankermsg").html(d.message);
                        }else if(d.status == 300){
                            pagetop();
                            $(".bankermsg").html(d.message);
                            window.setTimeout(function(){location.reload()},2000)
                        }
                    },
                    error: function (d) {
                        console.log(d);
                    }
            });
        });

        //Delete
        var dlturl = "{{URL::to('/user/delete-account')}}";
        $("#contentContainer").on('click','#deleteBtn', function(){
            
                if(!confirm('Sure?')) return;
                codeid = $(this).attr('rid');
                info_url = dlturl + '/'+codeid;
                $.ajax({
                    url:info_url,
                    method: "GET",
                    type: "DELETE",
                    data:{
                    },
                    success: function(d){
                        if(d.success) {
                            alert(d.message);
                            location.reload();
                        }
                    },
                    error:function(d){
                        console.log(d);
                    }
                });
            });
            //Delete

  });
</script>
{{-- @endsection --}}
    <script>
        $(function () {
            $.ajaxSetup({
                headers: {'X-CSRF-Token': '{{csrf_token()}}'}
            });

            var id = $('input[name="id"]').val();


            $('#image').change(function () {
                var photo = $(this)[0].files[0];
                var formData = new FormData();
                formData.append('id', id);
                formData.append('photo', photo);

                $.ajax({
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                console.log(percentComplete);
                                $('.progress-bar').css('width', percentComplete + '%');
                                if (percentComplete === 100) {
                                    console.log('completed 100%')

                                    var imageUrl = window.URL.createObjectURL(photo)
                                    $('.imgPreview').attr('src', imageUrl);
                                    setTimeout(function () {
                                        $('.progress-bar').css('width', '0%');
                                    }, 2000)
                                }
                            }
                        }, false);
                        return xhr;
                    },

                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        if(!res.success){alert(res.error)}
                    }
                })
            })
        })
    </script>

<script type="text/javascript">
  $(document).ready(function() {
      $("#profileinfo").addClass('active');
      $("#profileinfo").addClass('is-expanded');
      $("#profile").addClass('active');
  });
</script>
@endsection
