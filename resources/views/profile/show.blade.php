@php
$kin = auth()->user()->kin;
@endphp

@extends('layouts.app')

@section('title', __('My Profile'))

@section('head')
<link rel="stylesheet" href="{{ asset('assets_admin/bundles/bootstrap-social/bootstrap-social.css') }}">
<link rel="stylesheet" href="{{ asset('assets_admin/bundles/summernote/summernote-bs4.css') }}">
<style type="text/css">
    div {
      position: relative;
      overflow: hidden;
    }
    input[type='file'] {
      position: absolute;
      font-size: 50px;
      opacity: 0;
      right: 0;
      top: 0;
    }
</style>
@endsection

@section('bread')
<h1>Profile</h1>
<div class="section-header-breadcrumb">
    <div class="breadcrumb-item active"><a href="/dashboard"><i class="fas fa-home"></i></a></div>
    <div class="breadcrumb-item"><a href="#">Profile</a></div>
</div>
@endsection

@section('content')
<div class="row mt-sm-4 background-image-body">
    <div class="col-md-12 col-lg-12 box-center">
        <div class="row author-box">
            <img alt="{{ auth()->user()->firstname }}" src="{{ asset(auth()->user()->profile_photo_path) }}" class="rounded-circle author-box-picture box-center mt-4">
        </div>
        <div class="row author-box">
            <div class="page-inner box-center align-center">
                <h2><a href="#">{{ ucwords(auth()->user()->fullname()) }}</a></h2>
                <div class="page-description">
                    <h5>{{ ucwords(auth()->user()->user_data()->Occupation ?? 'user') }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-sm-4">
    <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="padding-0">
                <div class="card-header">
                    <h4>Update your account's profile information and email address.</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('updateProfile') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label>Photo</label><br>
                        <img id="uploadPreview" alt="{{ auth()->user()->firstname }}" src="{{ asset(auth()->user()->profile_photo_path) }}" style="width: 100px; height: 100px;border:2px solid #ECF4FF;object-fit: cover;border-radius: 50px;background: #ECF4FF"><br>
                        <div class="file btn btn-lg btn-primary mt-2">
                            SELECT A NEW PHOTO
                            <input type="file" onchange="PreviewImage()" name="photo" id="attach" accept="image/*" />
                        </div>
                        <div class="form-group mt-3">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="firstname" value="{{ auth()->user()->firstname }}" required="">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lastname" value="{{ auth()->user()->lastname }}" required="">
                        </div>
                        <div class="form-group">
                            <label>Other Name</label>
                            <input type="text" class="form-control" name="othername" value="{{ auth()->user()->othername }}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" value="{{ auth()->user()->email }}" readonly="">
                        </div>
                        <div class="form-group">
                            <label>Mobile Number</label>
                            <input type="text" class="form-control" name="mobile" value="{{ auth()->user()->mobile }}" required="">
                        </div>
                        @if(auth()->user()->account_type == "Cooperate")
                        <div class="row mt-2">
                            <div class="form-group">
                                <label>Company name</label>
                                <input type="text" class="form-control" name="company_name" value="{{ auth()->user()->company()->company_name ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label>RC Number</label>
                                <input type="text" class="form-control" name="rc_number" value="{{ auth()->user()->company()->rc_number ?? '' }}" required="">
                            </div>
                            <div class="form-group">
                                <label>Tax ID Number</label>
                                <input type="text" class="form-control" name="tin" value="{{ auth()->user()->company()->tin ?? '' }}" required="">
                            </div>
                            <div class="form-group">
                                <label>Company Address</label>
                                <input type="text" class="form-control" name="c_address" value="{{ auth()->user()->company()->c_address ?? '' }}" required="">
                            </div>
                        </div>
                        @endif
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="padding-0">
                <div class="card-header">
                    <h4>Edit Account Data</h4>
                </div>
                <div class="card-body">
                    <form method="post" class="needs-validation" action="{{ route('updateInfo') }}">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-4 col-12">
                                    <label>Mother Name</label>
                                    <input type="text" class="form-control" name="mother_name" value="{{ auth()->user()->user_data()->mother_name ?? '' }}">
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>DOB</label>
                                    <input type="date" class="form-control" name="dob" value="{{ auth()->user()->user_data()->dob ?? '' }}">
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>Gender</label>
                                    <select class="form-control" name="gender">
                                        <option value="">__select___</option>
                                        <option value="male" {{ (auth()->user()->user_data() != null && auth()->user()->user_data()->gender == 'male')?'selected':'' }}>Male</option>
                                        <option value="female" {{ (auth()->user()->user_data() != null && auth()->user()->user_data()->gender == 'female')?'selected':'' }}>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-12">
                                    <label>BVN</label>
                                    <input type="text" class="form-control" name="bvn" value="{{ auth()->user()->user_data()->bvn ?? '' }}">
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>Means of Identification</label>
                                    <select class="form-control" name="identification">
                                        <option value="">__select___</option>
                                        <option value="International Passport" {{ (auth()->user()->user_data() != null && auth()->user()->user_data()->identification == 'International Passport')?'selected':'' }}>International Passport</option>
                                        <option value="National Identification Card" {{ (auth()->user()->user_data() != null && auth()->user()->user_data()->identification == 'National Identification Card')?'selected':'' }}>National Identification Card</option>
                                        <option value="Drivers License" {{ (auth()->user()->user_data() != null && auth()->user()->user_data()->identification == 'Drivers License')?'selected':'' }}>Drivers License</option>
                                        <option value="Voters’ card" {{ (auth()->user()->user_data() != null && auth()->user()->user_data()->identification == 'Voters’ card')?'selected':'' }}>Voters’ card</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>Identification Number</label>
                                    <input type="text" class="form-control" name="identification_number" value="{{ auth()->user()->user_data()->identification_number ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-12">
                                    <label>Issued Date</label>
                                    <input type="date" class="form-control" name="issued_date" value="{{ auth()->user()->user_data()->issued_date ?? '' }}">
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>Expiry Date</label>
                                    <input type="date" class="form-control" name="expiry_date" value="{{ auth()->user()->user_data()->expiry_date ?? '' }}">
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address" value="{{ auth()->user()->user_data()->address ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-12">
                                    <label>State</label>
                                    <input type="text" class="form-control" name="state" value="{{ auth()->user()->user_data()->state ?? '' }}">
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="city" value="{{ auth()->user()->user_data()->city ?? '' }}">
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>Country</label>
                                    <input type="text" class="form-control" name="country" value="{{ auth()->user()->user_data()->country ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>Marital Status</label>
                                    <select class="form-control" name="marital_status">
                                        <option value="">__select___</option>
                                        <option value="single" {{ (auth()->user()->user_data() != null && auth()->user()->user_data()->marital_status == 'single')?'selected':'' }}>Single</option>
                                        <option value="married" {{ (auth()->user()->user_data() != null && auth()->user()->user_data()->marital_status == 'married')?'selected':'' }}>Married</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Occupation</label>
                                    <input type="text" class="form-control" name="occupation" value="{{ auth()->user()->user_data()->occupation ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-12">
                                    <label>Employer</label>
                                    <input type="text" class="form-control" name="employer" value="{{ auth()->user()->user_data()->employer ?? '' }}">
                                </div>
                                <div class="form-group col-md-8 col-12">
                                    <label>Employer Address</label>
                                    <input type="text" class="form-control" name="employer_address" value="{{ auth()->user()->user_data()->employer_address ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-12">
                                    <label>Bank Name</label>
                                    <input type="text" class="form-control" name="bank_name" value="{{ auth()->user()->user_data()->bank_name ?? '' }}">
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>Account Name</label>
                                    <input type="text" class="form-control" name="account_name" value="{{ auth()->user()->user_data()->account_name ?? '' }}">
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>Account Number</label>
                                    <input type="text" class="form-control" name="account_number" value="{{ auth()->user()->user_data()->account_number ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="padding-0">
                <div class="card-header">
                    <h4>Next of Kin Details</h4>
                </div>
                <div class="card-body">
                    <form method="post" class="needs-validation" action="{{ route('updateKin') }}">
                        @csrf
                        <div class="row mt-5">
                            <div class="form-group col-md-4 col-12">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="firstname" value="{{ $kin->firstname ?? '' }}" required="">
                            </div>
                            <div class="col-md-4 col-12">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lastname" value="{{ $kin->lastname ?? '' }}" required="">
                            </div>
                            <div class="col-md-4 col-12">
                                <label>Other Name</label>
                                <input type="text" class="form-control" name="othername" value="{{ $kin->othername ?? '' }}">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6 col-12">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" value="{{ $kin->email ?? '' }}" required="">
                            </div>
                            <div class="col-md-6 col-12">
                                <label>Mobile Number</label>
                                <input type="text" class="form-control" name="mobile" value="{{ $kin->mobile ?? '' }}" required="">
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="form-group col-md-6 col-12">
                                <label>Relationship</label>
                                <input type="text" class="form-control" name="relationship" value="{{ $kin->relationship ?? '' }}" required="">
                            </div>
                            <div class="col-md-6 col-12">
                                <label>Date of Birth</label>
                                <input type="date" class="form-control" name="dob" value="{{ $kin->dob ?? '' }}" required="">
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="padding-0">
                <div class="card-header">
                    <h4>Ensure your account is using a long, random password to stay secure.</h4>
                </div>
                <div class="card-body">
                    <form method="post" class="needs-validation" action="{{ route('updatePassword') }}">
                        @csrf
                        <div class="row mt-5">
                            <div class="form-group col-md-4 col-12">
                                <label>Current Password</label>
                                <input type="password" class="form-control" name="current_password">
                                @error('current_password')
                                    <div class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-12">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password">
                                @error('password')
                                    <div class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-12">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('foot')
<script src="{{ asset('assets_admin/bundles/summernote/summernote-bs4.min.js') }}"></script>
<script type="text/javascript">
    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("attach").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        }
    }
</script>
@endsection