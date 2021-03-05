@extends('layouts.adminAuth')

@section('title', __('User Dashboard'))

@section('content')
<div class="card card-auth">
    <div class="card-header card-header-auth">
        <h4>Forget Password</h4>
    </div>
    <div class="card-body">
        <p class="text-muted">{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <form method="POST" action="{{ route('password.email') }}" class="needs-validation" novalidate="">
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
                <button type="submit" class="btn btn-lg btn-block btn-auth-color" tabindex="4">
                {{ __('Email Password Reset Link') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection