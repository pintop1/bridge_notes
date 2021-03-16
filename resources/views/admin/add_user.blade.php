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
<h1>Add new User</h1>
<div class="section-header-breadcrumb">
    <div class="breadcrumb-item active"><a href="/admin/dashboard"><i class="fas fa-home"></i></a></div>
    <div class="breadcrumb-item active"><a href="/admin/users"><i class="fas fa-user"></i></a></div>
    <div class="breadcrumb-item"><a href="#">Add User</a></div>
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
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mt-3">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="firstname" required="">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lastname" required="">
                        </div>
                        <div class="form-group">
                            <label>Other Name</label>
                            <input type="text" class="form-control" name="othername">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Mobile Number</label>
                            <input type="text" class="form-control" name="mobile" required="">
                        </div>
                        <div class="form-group">
			                <label for="type">{{ __('Account Type') }}</label>
			                <select class="form-control select2" required name="type">
			                    <option value="">Select a type</option>
			                    <option>Personal</option>
			                    <option>Cooperate </option>
			                </select>
			            </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Save</button>
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