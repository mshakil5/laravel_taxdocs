@extends('layouts.app')

@section('content')



    <section class="login-content">
      <div class="logo">
        <h1>Taxdocs</h1>
      </div>

      <div class="login-box">
        <form method="POST" action="{{ route('login') }}" class="login-form" >
                @csrf
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
          @if (isset($message))
            <span class="login-head" role="alert">
                <strong><p style="color: red">{{ $message }}</p></strong>
            </span>
            @endif
          <div class="form-group">
            <label class="control-label">EMAIL</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="form-group">
            <label class="control-label">PASSWORD</label>
            
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

          </div>
          
          <div class="form-group btn-container">
            <button  type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
          </div>
        

            <div class="form-group">
                <div class="utility">
                <div class="animated-checkbox">
                  <p class="semibold-text mb-2"><a href="{{ route('register') }}">Register</a></p>
                </div>
                <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Forgot Password ?</a></p>
                </div>
            </div>
        </form>
        <form method="POST" class="forget-form" action="{{ route('password.email') }}">
            @csrf
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>
          <div class="form-group">
            <label class="control-label">EMAIL</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

              @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>RESET</button>
          </div>
          <div class="form-group mt-3">
            <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
          </div>
        </form>

      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    

@endsection