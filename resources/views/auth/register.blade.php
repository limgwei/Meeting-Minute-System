@extends('layouts.app')

@section('content')
<div class="card container d-flex flex-column justify-content-between align-items-center" style="max-width:400px;border-radius:12px">
    <form method="POST" action="{{ route('register') }}" style="margin-top:auto;margin-bottom:auto">
        @csrf
        <div class="font-regular">{{ __('auth.welcome') }}</div>
        <div class="font-big">{{ __('auth.register_text') }}</div>

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

        <!-- email -->
        <div class="margin-tb-10">
            <label for="name" class="font-regular">{{ __('auth.name') }}</label>
            <input id="name" type="text" class="form-control " name="name" required placeholder="name123">
        </div>


        <!-- password -->
        <div class="margin-tb-10">
            <label for="password" class="font-regular">{{ __('auth.passowrd_text') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        </div>

        <!-- confirm password -->
        <div class="margin-tb-10">
            <label for="password" class="font-regular">{{ __('auth.confirm_passowrd_text') }}</label>
            <input id="password" type="password" class="form-control " name="password_confirmation" required autocomplete="new-password">
        </div>

        <!-- Login button -->
        <div>
            <button class="btn btn-primary inter-bold" style="width:100%">{{ __('auth.register_now') }}</button>
        </div>

    </form>
    <div>
        <label style="text-align:center;width:100%;">{{ __('auth.login_text') }} <a href="{{ route('login') }}">{{ __('auth.login_link') }}</a></label>
    </div>
</div>
@endsection