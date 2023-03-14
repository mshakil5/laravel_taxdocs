@extends('layouts.app')

@section('content')



    <section class="login-content">
      <div class="logo">
        <h1>Accountancy</h1>
      </div>

      <div class="login-box">
        <form method="POST" action="{{ route('password.update') }}"  class="login-form" >
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Reset Password</h3>
            @if (isset($message))
            <span class="login-head" role="alert">
                <strong><p style="color: red">{{ $message }}</p></strong>
            </span>
            @endif

          <div class="form-group">
            <label class="control-label">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

          <div class="form-group">
            <label class="control-label">Password</label>
            
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

          </div>

          <div class="form-group">
            <label class="control-label">Confirm Password</label>
            
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

          </div>
          
          <div class="form-group btn-container">
            <button  type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>Reset Password</button>
          </div>
        

          
        </form>




      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    



    @endsection

