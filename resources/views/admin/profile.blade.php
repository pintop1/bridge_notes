@php
use App\Http\Controllers\Globals as Utils;
@endphp

@extends('layouts.admin')

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
    <div class="breadcrumb-item active"><a href="/admin/dashboard"><i class="fas fa-home"></i></a></div>
    <div class="breadcrumb-item"><a href="#">Profile</a></div>
</div>
@endsection

@section('content')
<div class="row mt-sm-4 background-image-body">
    <div class="col-md-12 col-lg-12 box-center">
        <div class="row author-box">
            <img alt="{{ $user->firstname }}" src="{{ asset($user->profile_photo_path) }}" class="rounded-circle author-box-picture box-center mt-4">
        </div>
        <div class="row author-box">
            <div class="page-inner box-center align-center">
                <h2><a href="#">{{ ucwords($user->firstname.' '.$user->lastname) }}</a></h2>
                <div class="page-description">
                    <h5>Administrator</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-sm-4">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="padding-20">
                <ul class="nav nav-pills mb-1" id="myTab2" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
                            aria-selected="true">Personal Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#password" role="tab"
                            aria-selected="false">Update Password</a>
                    </li>
                </ul>
                <div class="tab-content tab-bordered" id="myTab3Content">
                    <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
                        <form action="{{ route('admin.my.updateProfileInfo') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h4>Update your account's profile information and email address.</h4>
                            </div>
                            <div class="card-body">
                                <label>Photo</label><br>
                                <img id="uploadPreview" alt="{{ $user->firstname }}" src="{{ asset($user->profile_photo_path) }}" style="width: 100px; height: 100px;border:2px solid #ECF4FF;object-fit: cover;border-radius: 50px;background: #ECF4FF"><br>
                                <div class="file btn btn-lg btn-primary mt-2">
                                    SELECT A NEW PHOTO
                                    <input type="file" onchange="PreviewImage()" name="photo" id="attach" accept="image/*" />
                                </div>
                                <div class="row mt-5">
                                    <div class="form-group col-md-4 col-12">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" name="firstname" value="{{ $user->firstname }}" required="">
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" name="lastname" value="{{ $user->lastname }}" required="">
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <label>Other Name</label>
                                        <input type="text" class="form-control" name="othername" value="{{ $user->othername }}">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email" value="{{ $user->email }}" readonly="">
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label>Mobile Number</label>
                                        <input type="text" class="form-control" name="mobile" value="{{ $user->mobile }}" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-secondary">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="profile-tab4">
                        <form method="post" class="needs-validation" action="{{ route('admin.my.updatePassword') }}">
                            @csrf
                            <div class="card-header">
                                <h4>Ensure your account is using a long, random password to stay secure.</h4>
                            </div>
                            <div class="card-body">
                                <div class="row mt-5">
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
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
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