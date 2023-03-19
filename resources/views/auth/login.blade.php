<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Charity - Register</title>
    <link rel="icon" href="{{ url('css/favicon.jpg') }}">
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="./css/app.css">
</head>

<body>
    <!-- oncontextmenu="return false;" -->
 <style>
  .btn-theme {
  border: 0;
  width: auto;
  margin: 5px;
  border-radius: 7px;
  padding: 6px 15px;
  font-size: 22px;
  color: #fff;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}
.btn-theme:hover {
  color: #ffffff;
  background: #11517d !important;
}
.btn-theme::first-letter {
  text-transform: uppercase;
}
.btn-theme.bg-primary:hover {
  color: #ffffff;
  background: #F0BD57 !important;
}
.btn-theme.bg-secondary:hover {
  color: #ffffff;
  background: #265080 !important;
}
.btn-theme.btn-line {
  background: transparent !important;
  border: 1px solid #F0BD57;
  color: #F0BD57;
}
.btn-theme.btn-line:hover {
  background: #F0BD57 !important;
  color: #fff;
}
.authSection {
  display: flex;
  align-items: flex-start;
  justify-content: center;
  background-image: url(../monitor.svg);
  height: 100vh;
  width: 100%;
  background-repeat: no-repeat;
  background-size: contain;
  background-position: center center;
}
@media (max-width: 1230px) {
  .authSection {
    background-image: unset;
    background: aliceblue;
  }
}
.authSection .inner {
  width: 380px;
  margin: 0 auto;
  margin-top: 90px;
}

.login-form {
  background: rgba(38, 80, 128, 0.0705882353);
  padding: 25px;
  border-radius: 5px;
}

.plan {
  background-color: #fff7f2;
}

.advertisement {
  background-color: #e3d4c2;
}/*# sourceMappingURL=app.css.map */
 </style>

    <div class="authSection">
        <div class="inner">
            
            <div class="login" id="card">
                <div class="front signin_form"> 
                    <div class="d-flex align-items-center justify-content-center flex-column">
                      <a href="{{ route('homepage')}}" target="blank">
                        <img src="{{ asset('images/company/'.\App\Models\CompanyDetail::where('id',1)->first()->header_logo)}}" alt="">
                    </a>
                        <h4 class="mb-4 text-center">Login Your Account</h4>
                        @if (isset($message))
                        <span class="login-head" role="alert">
                            <strong><p style="color: red">{{ $message }}</p></strong>
                        </span>
                        @endif
                    </div>
                    
                    <form method="POST" action="{{ route('login') }}" class="login-form" >
                        @csrf
                        <div class="form-group mb-2">
                            <div class="input-group">
                                
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  placeholder="Type your email" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="input-group">
                              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                              @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>
                        </div>
                        
                        <div class="form-group sign-btn mt-1 d-flex align-items-center justify-content-between">
                            <input type="submit" class="btn-theme bg-primary ms-0 mb-2" value="Log in">
                            <div class="d-flex flex-column">
                              <p class="m-0"><a href="#" id="flip-btn" class="forgot forget_password_link txt-primary fs-6 fw-bold">Forgot Password ?</a></p>
                               <p class="text-end"> 
                                  <a href="{{ route('register')}}" class="signup  ms-2  txt-primary fs-6 fw-bold">
                                    Sign up 
                                  </a>
                              </p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="back forget_password_form" style="opacity: 0;"> 
                  <div class="d-flex align-items-center justify-content-center flex-column">
                    <a href="{{ route('homepage')}}" target="blank">
                      <img src="{{ asset('images/company/'.\App\Models\CompanyDetail::where('id',1)->first()->header_logo)}}" alt="">
                  </a>
                  <h4 class="mb-4 text-center">Sign Up for Your New Account</h4>
                  </div>

                  <form method="POST" class="login-form" action="{{ route('password.email') }}">
                      @csrf
                      <div class="form-group mb-2">
                          <div class="input-group">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
                
                              @error('email')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror 
                          </div>
                      </div>

                      <div class="form-group mb-2 sign-btn">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>RESET</button>
                          {{-- <input type="submit" class="btn-theme bg-primary ms-0 mt-3" value="Sign up"> --}}
                          <p class="fw-bold">You have already Account So 
                            <a href="#" id="unflip-btn" class="signup txt-primary fs-6 fw-bold">
                            Log in</a>
                          </p>
                      </div>


                  </form>
                </div>
            </div>
        </div>
    </div>

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="{{ asset('user/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('user/js/iconify.min.js')}}"></script>
    <script src="{{ asset('user/js/app.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Flip/1.0.18/jquery.flip.js"></script>

     <script>
      $().ready(function() {
	$("#card").flip({
	  trigger: 'manual'
	});
});


$(".forget_password_link").click(function() {

	$(".signin_form").css('opacity', '0');
	$(".forget_password_form").css('opacity', '100');
	
	
	$("#card").flip(true);
	
	return false;
});

$("#unflip-btn").click(function(){
  
	$(".signin_form").css('opacity', '100');
	$(".forget_password_form").css('opacity', '0');
	
  	$("#card").flip(false);
	
	return false;
	
});
       </script>

</body>

</html>