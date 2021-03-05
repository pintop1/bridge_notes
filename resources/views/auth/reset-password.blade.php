@extends('layouts.adminAuth')

@section('title', __('Reset Password'))

@section('content')
<div class="card card-auth">
    <div class="card-header card-header-auth">
        <h4>Reset Password</h4>
    </div>
    <div class="card-body">
        @if (session('status'))
        <div class="text-success mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
        @endif
        <form method="POST" action="{{ route('password.update') }}" class="needs-validation" novalidate="">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control" name="email" tabindex="1" value="{{ old('email', $request->email) }}" required autofocus>
                @error('email')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <input id="password" type="password" class="form-control" name="password" tabindex="2" required autocomplete="new-password">
                @error('password')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <input id="password" type="password" class="form-control" name="password_confirmation" tabindex="2" required autocomplete="new-password">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-lg btn-block btn-auth-color" tabindex="4">
                {{ __('Reset Password') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection