@extends('layouts.adminAuth')

@section('title', __('User Dashboard'))

@section('content')
<div class="card card-auth">
    <div class="card-header card-header-auth">
        <h4>User Login</h4>
    </div>
    <div class="card-body">
        @if (session('status'))
        <div class="text-success mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
        @endif
        <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
            @csrf
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control" name="email" tabindex="1" value="{{ old('email') }}" required autofocus>
                @error('email')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                @if (Route::has('password.request'))
                <div class="d-block">
                    <label for="password" class="control-label">Password</label>
                    <div class="float-right">
                        <a href="{{ route('password.request') }}" class="text-small">
                        Forgot Password?
                        </a>
                    </div>
                </div>
                @endif
                <input id="password" type="password" class="form-control" name="password" tabindex="2" required autocomplete="current-password">
                @error('password')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                    <label class="custom-control-label" for="remember-me">Remember Me</label>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-lg btn-block btn-auth-color" tabindex="4">
                Login
                </button>
            </div>
            {{--<div class="text-center text-bold">Don't have an account yet? <a href="/register">Sign up</a></div>--}}
        </form>
    </div>
</div>
@endsection