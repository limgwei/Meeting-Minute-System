@extends('layouts.app')

@section('content')
<div class="container d-flex flex-column justify-content-between align-items-center" style="max-width:400px;">
  <form method="POST" action="{{ route('login') }}" style="margin-top:auto;margin-bottom:auto">
    @csrf
    <div class="font-regular">{{ __('auth.welcome_back') }}</div>
    <div class="font-big">{{ __('auth.login_text') }}</div>
    <!-- email -->
    <div class="margin-tb-10">
      <label for="email" class="font-regular">{{ __('auth.email') }}</label>
      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="123@gmail.com">
      @error('email')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>


    <!-- password -->
    <div class="margin-tb-10">
      <label for="password" class="font-regular">{{ __('auth.passowrd_text') }}</label>
      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
    </div>

    <!-- remember me and forget password -->
    <div class="d-flex justify-content-between margin-tb-10">
      <label for="remember_me"><input type="checkbox" value="remember_me" class="checkbox-round" {{ old('remember') ? 'checked' : '' }}>{{ __('auth.remember_me') }}</label>
      <label for="forget_password"><a href="{{ route('password.request') }}">{{ __('auth.forget_password') }}</a></label>
    </div>

    <!-- Login button -->
    <div>
      <button class="btn btn-primary inter-bold" style="width:100%">{{ __('auth.login_now') }}</button>
    </div>

  </form>
  <div>
    <label style="text-align:center;width:100%;">{{ __('auth.sign_up_text') }} <a href="{{ route('register') }}">{{ __('auth.sign_up_link') }}</a></label>
  </div>
</div>
@endsection