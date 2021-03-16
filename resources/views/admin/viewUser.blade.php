@php
$kin = $user->kin;
@endphp

@extends('layouts.admin')

@section('title', __('User Profile'))

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
    <div class="breadcrumb-item active"><a href="/admin/dashboard"><i class="fas fa-home"></i></a></div>
    <div class="breadcrumb-item"><a href="#">Profile</a></div>
</div>
@endsection

@section('content')
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
                        <input type="hidden" name="user" value="{{ $user->id }}">
                        <label>Photo</label><br>
                        <img id="uploadPreview" alt="{{ $user->firstname }}" src="{{ asset($user->profile_photo_path) }}" style="width: 100px; height: 100px;border:2px solid #ECF4FF;object-fit: cover;border-radius: 50px;background: #ECF4FF"><br>
                        <div class="file btn btn-lg btn-primary mt-2">
                            SELECT A NEW PHOTO
                            <input type="file" onchange="PreviewImage()" name="photo" id="attach" accept="image/*" />
                        </div>
                        <div class="form-group mt-3">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="firstname" value="{{ $user->firstname }}" required="">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lastname" value="{{ $user->lastname }}" required="">
                        </div>
                        <div class="form-group">
                            <label>Other Name</label>
                            <input type="text" class="form-control" name="othername" value="{{ $user->othername }}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" value="{{ $user->email }}" readonly="">
                        </div>
                        <div class="form-group">
                            <label>Mobile Number</label>
                            <input type="text" class="form-control" name="mobile" value="{{ $user->mobile }}" required="">
                        </div>
                        @if($user->account_type == "Cooperate")
                        <div class="row mt-2">
                            <div class="form-group">
                                <label>Company name</label>
                                <input type="text" class="form-control" name="company_name" value="{{ $user->company()->company_name ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label>RC Number</label>
                                <input type="text" class="form-control" name="rc_number" value="{{ $user->company()->rc_number ?? '' }}" required="">
                            </div>
                            <div class="form-group">
                                <label>Tax ID Number</label>
                                <input type="text" class="form-control" name="tin" value="{{ $user->company()->tin ?? '' }}" required="">
                            </div>
                            <div class="form-group">
                                <label>Company Address</label>
                                <input type="text" class="form-control" name="c_address" value="{{ $user->company()->c_address ?? '' }}" required="">
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
                        <input type="hidden" name="user" value="{{ $user->id }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-4 col-12">
                                    <label>Mother Name</label>
                                    <input type="text" class="form-control" name="mother_name" value="{{ $user->user_data()->mother_name ?? '' }}">
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>DOB</label>
                                    <input type="date" class="form-control" name="dob" value="{{ $user->user_data()->dob ?? '' }}">
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>Gender</label>
                                    <select class="form-control" name="gender">
                                        <option value="">__select___</option>
                                        <option value="male" {{ ($user->user_data() != null && $user->user_data()->gender == 'male')?'selected':'' }}>Male</option>
                                        <option value="female" {{ ($user->user_data() != null && $user->user_data()->gender == 'female')?'selected':'' }}>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-12">
                                    <label>BVN</label>
                                    <input type="text" class="form-control" name="bvn" value="{{ $user->user_data()->bvn ?? '' }}">
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>Means of Identification</label>
                                    <select class="form-control" name="identification">
                                        <option value="">__select___</option>
                                        <option value="International Passport" {{ ($user->user_data() != null && $user->user_data()->identification == 'International Passport')?'selected':'' }}>International Passport</option>
                                        <option value="National Identification Card" {{ ($user->user_data() != null && $user->user_data()->identification == 'National Identification Card')?'selected':'' }}>National Identification Card</option>
                                        <option value="Drivers License" {{ ($user->user_data() != null && $user->user_data()->identification == 'Drivers License')?'selected':'' }}>Drivers License</option>
                                        <option value="Voters’ card" {{ ($user->user_data() != null && $user->user_data()->identification == 'Voters’ card')?'selected':'' }}>Voters’ card</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>Identification Number</label>
                                    <input type="text" class="form-control" name="identification_number" value="{{ $user->user_data()->identification_number ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-12">
                                    <label>Issued Date</label>
                                    <input type="date" class="form-control" name="issued_date" value="{{ $user->user_data()->issued_date ?? '' }}">
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>Expiry Date</label>
                                    <input type="date" class="form-control" name="expiry_date" value="{{ $user->user_data()->expiry_date ?? '' }}">
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address" value="{{ $user->user_data()->address ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-12">
                                    <label>State</label>
                                    <input type="text" class="form-control" name="state" value="{{ $user->user_data()->state ?? '' }}">
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="city" value="{{ $user->user_data()->city ?? '' }}">
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>Country</label>
                                    <input type="text" class="form-control" name="country" value="{{ $user->user_data()->country ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>Marital Status</label>
                                    <select class="form-control" name="marital_status">
                                        <option value="">__select___</option>
                                        <option value="single" {{ ($user->user_data() != null && $user->user_data()->marital_status == 'single')?'selected':'' }}>Single</option>
                                        <option value="married" {{ ($user->user_data() != null && $user->user_data()->marital_status == 'married')?'selected':'' }}>Married</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Occupation</label>
                                    <input type="text" class="form-control" name="occupation" value="{{ $user->user_data()->occupation ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-12">
                                    <label>Employer</label>
                                    <input type="text" class="form-control" name="employer" value="{{ $user->user_data()->employer ?? '' }}">
                                </div>
                                <div class="form-group col-md-8 col-12">
                                    <label>Employer Address</label>
                                    <input type="text" class="form-control" name="employer_address" value="{{ $user->user_data()->employer_address ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-12">
                                    <label>Bank Name</label>
                                    <input type="text" class="form-control" name="bank_name" value="{{ $user->user_data()->bank_name ?? '' }}">
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>Account Name</label>
                                    <input type="text" class="form-control" name="account_name" value="{{ $user->user_data()->account_name ?? '' }}">
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>Account Number</label>
                                    <input type="text" class="form-control" name="account_number" value="{{ $user->user_data()->account_number ?? '' }}">
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
                        <input type="hidden" name="user" value="{{ $user->id }}">
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

    {{--<div class="col-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="padding-0">
                <div class="card-header">
                    <h4>Ensure your account is using a long, random password to stay secure.</h4>
                </div>
                <div class="card-body">
                    <form method="post" class="needs-validation" action="{{ route('updatePassword') }}">
                        @csrf
                        <input type="hidden" name="user" value="{{ $user->id }}">
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
    </div>--}}

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