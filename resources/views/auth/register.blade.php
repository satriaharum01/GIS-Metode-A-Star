@extends('layouts.app')

@section('content')
<div class="container">
	<div class="signup-screen">
		<div class="signup__content">
			<span>
				<label class="headerlabel">
					SIGN UP FORM</label>
			</span>
			<form class="signup" method="POST" action="{{ route('register') }}">
				@csrf
				<div class="signup__field">
					<i class="signup__icon fas fa-user"></i>
					<input id="name" type="text" placeholder="Username" class="signup__input form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

					@error('name')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
				<button class="button register__submit">
					<span class="button__text">Register</span>
					<i class="button__icon fas fa-chevron-right"></i>
					<span class="underbutton">
						Already Register <a href="{{ url('/login') }}">Log in</a>
					</span>
				</button>
				<div class="signup__field">
					<i class="signup__icon fas fa-lock"></i>
					<input id="email" type="email" placeholder="Email" class="signup__input form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

					@error('email')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
				<div class="signup__field">
					<i class="signup__icon fas fa-lock"></i>
					<input id="password" type="password" placeholder="Password" class="signup__input form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

					@error('password')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
				<div class="signup__field">
					<i class="signup__icon fas fa-lock"></i>
					<input id="password-confirm" placeholder="Confirm Password" type="password" class="signup__input form-control" name="password_confirmation" required autocomplete="new-password">
				</div>
			</form>
		</div>
		<div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<span class="screen__background__shape screen__background__shape3"></span>
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div>
		<span class="label-powered">
			Powered by <a href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
		</span>
	</div>

</div>
<!-- partial -->

@endsection