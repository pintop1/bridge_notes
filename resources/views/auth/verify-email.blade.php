@extends('layouts.adminAuth')

@yield('title', __('Verify Account'))

@section('content')
<div class="card card-auth">
    <div class="card-header card-header-auth">
        <h4>Verify Account</h4>
    </div>
    <div class="card-body">
        @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
        @endif
        <div class="form-group">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div class="form-group">
                <button class="btn btn-primary" type="submit">{{ __('Resend Verification Email') }}</button>
            </div>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <div class="float-right">
                <button type="submit" class="btn btn-link underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Logout') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection