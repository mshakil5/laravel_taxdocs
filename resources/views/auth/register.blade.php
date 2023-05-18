@extends('frontend.layouts.master')

@section('content')


<section class="auth py-4">
  <div class="container">
      <div class="row">
          <div class="col-lg-12 d-flex justify-content-center mt-5">
            <div class="title mb-5">Create an account</div>
          </div>
          @if (isset($message))
          <span class="login-head" role="alert">
              <strong><p style="color: red">{{ $message }}</p></strong>
          </span>
          @endif
      </div>
      <div class="row">
          <div class="col-lg-10 mx-auto">
              <div class="row">
                  <div class="col-lg-4 d-flex align-items-center justify-content-center">
                      <img src="{{ asset('front/images/log in page 1.svg')}}" alt="" class="w-100">
                  </div>
                  <div class="col-lg-8">
                    <form class="form-custom" action="{{route('register')}}" method="POST">
                      @csrf

                      <div class="row">

                        <div class="col-lg-6">
                          <div class="form-group">
                              <input class="form-control" type="text" id="name" name="name" placeholder="First Name" value="{{ old('name') }}" required> 
                          </div>
                        </div>

                        <div class="col-lg-6">
                          <div class="form-group">
                            <input class="form-control" type="text" id="surname" name="surname" placeholder="Surname"  value="{{ old('surname') }}" required> 
                          </div>
                        </div>

                        <div class="col-lg-6">
                          <div class="form-group">
                            <input class="form-control" type="number" id="phone" name="phone" placeholder="Contact number" value="{{ old('phone') }}" required> 
                          </div>
                        </div>

                        <div class="col-lg-6">
                          <div class="form-group">
                            <input class="form-control" type="text"  name="accountant_name" id="accountant_name"  placeholder="Accountant Name" value="{{ old('accountant_name') }}" required> 
                          </div>
                        </div>

                        <div class="col-lg-6">
                          <div class="form-group">
                            <input class="form-control" type="text" id="bname" name="bname" placeholder="Business name" value="{{ old('bname') }}" required> 
                          </div>
                        </div>

                        <div class="col-lg-6">
                          <div class="form-group">
                            <select name="sub_plan" id="sub_plan" class="form-control" required>
                              <option value="">Our Service Plan</option>
                              <option value="1">Individual Plan</option>
                              <option value="2">Standard Business Plan</option>
                              <option value="2">Premier Business Plan</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-6" style="display: none">
                          
                          <div class="form-group">
                            <input class="form-control" type="number" id="bank_account_number" name="bank_account_number"  value="{{ old('bank_account_number') }}" placeholder="Bank account number" required> 
                          </div>
                        </div>
                        <div class="col-lg-6" style="display: none">
                          <div class="form-group">
                            <input class="form-control" type="number" id="bank_account_code" name="bank_account_code" placeholder="Bank account sort-code"   value="{{ old('bank_account_code') }}" required> 
                          </div>
                        </div>

                      </div>
                      <div class="title" style="font-size: 25px">Address</div><hr>
                      <div class="row">
                        <div class="col-lg-6">
                          
                          <div class="form-group">
                              <input class="form-control" type="text" id="house_number" name="house_number" placeholder="House number" value="{{ old('house_number') }}" required> 
                          </div>

                          <div class="form-group">
                            <input class="form-control" type="text" id="street" name="street" placeholder="Street name"  value="{{ old('street') }}" required> 
                        </div>


                        </div>
                        <div class="col-lg-6">
                          
                          <div class="form-group">
                            <input class="form-control" type="text" id="town" name="town" placeholder="Town"  value="{{ old('town') }}"> 
                          </div>
                          <div class="form-group">
                              <input class="form-control" type="text" id="postcode" name="postcode" placeholder="Post code"   value="{{ old('postcode') }}" required> 
                          </div>
                        </div>
                      </div>

                      <div class="title" style="font-size: 25px">Credentials</div><hr>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" placeholder="Email"  value="{{ old('email') }}" required> 
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                        </div>

                        <div class="col-lg-6">
                          <div class="form-group">
                            <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" placeholder="Password" required> 
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required> 
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>

                        </div>
                      </div>


                        <div class="form-group">
                          <button type="submit" class="btn-theme bg-primary d-block text-center mx-0 w-100">Sign up</button>
                        </div>
                        
                        <div class="form-group d-flex justify-content-center">
                            <span class="txt-primary fs-20 me-2 ">or</span>
                            <a href="{{ route('login')}}" class="theme-link"> log into another account</a>
                        </div>
                    </form> 
                  </div>
                  
                 
              </div>
          </div>
      </div>
  </div>
</section> 



@endsection

@section('script')
<script>

</script>
@endsection

