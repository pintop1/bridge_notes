@extends('layouts.adminAuth')

@section('title', __('User Sign Up'))

@section('content')
<div class="card card-auth">
    <div class="card-header card-header-auth">
        <h4>User Registration</h4>
    </div>
    <div class="card-body">
        @if (session('status'))
        <div class="text-success mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
        @endif
        <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate="">
            @csrf
            <div class="form-group">
                <label for="fname">{{ __('First Name') }}</label>
                <input id="fname" type="text" class="form-control" name="firstname" tabindex="1" value="{{ old('firstname') }}" required autofocus>
                @error('firstname')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="lname">{{ __('Last Name') }}</label>
                <input id="lname" type="text" class="form-control" name="lastname" tabindex="1" value="{{ old('lastname') }}" required>
                @error('lastname')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control" name="email" tabindex="1" value="{{ old('email') }}" required>
                @error('email')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control" name="password" tabindex="2" required autocomplete="current-password">
                @error('password')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="pass">{{ __('Confirm Password') }}</label>
                <input id="pass" type="password" class="form-control" name="password_confirmation" tabindex="1" required>
            </div>
            <div class="form-group">
                <label for="type">{{ __('Account Type') }}</label>
                <select class="form-control select2" required name="type">
                    <option value="">Select a type</option>
                    <option>Personal</option>
                    <option>Cooperate </option>
                </select>
            </div>
            <!--<div class="show">
                <div class="form-group">
                    <label>Company name</label>
                    <input type="text" class="form-control" name="company_name" tabindex="1">
                </div>
                <div class="form-group">
                    <label>RC Number</label>
                    <input type="text" class="form-control" name="rc_number" tabindex="1">
                </div>
                <div class="form-group">
                    <label>Tax ID number</label>
                    <input type="text" class="form-control" name="tin" tabindex="1">
                </div>
                <div class="form-group">
                    <label>Company Address</label>
                    <input type="text" class="form-control" name="c_address" tabindex="1">
                </div>
            </div>-->
            <div class="form-group">
                <button type="submit" class="btn btn-lg btn-block btn-auth-color" tabindex="4">
                SUBMIT
                </button>
            </div>
            <div class="text-center text-bold">Already a member? <a href="/login">Sign In</a></div>
        </form>
    </div>
</div>
<script>
    $(function(){
        /*$('.show').hide();
        $('select[name="type"]').on('change', function(){
            var selected = $(this).children("option:selected").val();
            if(selected == 'Cooperate'){
                $('.show').show();
            }
        });*/
    });
</script>
@endsection