@extends('layouts.app')

@section('content')
<div class="limiter">
  <div class="container-login100">
    <div class="wrap-login100">
      <div class="login100-form-title" style="background-image: url(logincss/images/bg-01.jpg);">
        <span class="login100-form-title-1">
          Sign In
        </span>
      </div>

      <form class="login100-form validate-form" method="POST" action="{{ route('login') }}" role="login">
        @csrf
        @error('email')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
        <div class="wrap-input100 validate-input m-b-26" data-validate="Email is required">
          <span class="label-input100">Email</span>
          <input class="input100" id="email" type="email" name="email" placeholder="Enter email">
          <span class="focus-input100"></span>
        </div>

        @error('password')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
        <div class="wrap-input100 validate-input m-b-18" data-validate="Password is required">
          <span class="label-input100">Password</span>
          <input class="input100" type="password" name="password" id="password" placeholder="Enter password">
          <span class="focus-input100"></span>
        </div>

        <div class="flex-sb-m w-full p-b-30">
          <div class="contact100-form-checkbox">
          </div>

          <div>
          </div>
        </div>

        <div class="container-login100-form-btn">
          <button class="login100-form-btn">
            Login
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection