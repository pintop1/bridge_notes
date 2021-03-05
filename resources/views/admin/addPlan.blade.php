@php
use App\Http\Controllers\Globals as Utils;
@endphp

@extends('layouts.admin')

@section('title')
@if(isset($edit))
Edit Plan
@else
Add New Plan
@endif
@endsection

@section('head')
<script src="{{ asset('assets_admin/bundles/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets_admin/bundles/tinymce/jquery.tinymce.min.js') }}"></script>
<script type="text/javascript">
  tinymce.init({
    selector:"#textarea",
    themes: "modern",
    skin: "oxide",
    height:300,
    plugins:["advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker","searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking","save table contextmenu directionality emoticons template paste textcolor"],
    toolbar:"insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
    style_formats:[{title:"Bold text",inline:"b"},{title:"Red text",inline:"span",styles:{color:"#ff0000"}},{title:"Red header",block:"h1",styles:{color:"#ff0000"}},{title:"Example 1",inline:"span",classes:"example1"},{title:"Example 2",inline:"span",classes:"example2"},{title:"Table styles"},{title:"Table row 1",selector:"tr",classes:"tablerow1"}]
	});
</script>
@endsection

@section('bread')
<h1>Plans</h1>
<div class="section-header-breadcrumb">
	<div class="breadcrumb-item"><a href="/admin/dashboard"><i class="fas fa-home"></i></a></div>
	<div class="breadcrumb-item"><a href="/admin/plans"><i class="far fa-chart-bar"></i></a></div>
	<div class="breadcrumb-item active"><a href="#"> @if(isset($edit)) Edit Plan @else Add New Plan @endif </a></div>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-6">
		@if(isset($edit))
		<form action="{{ route('admin.plans.edit') }}" method="post" enctype="multipart/form-data">
			@csrf
			<div class="card">
				<div class="card-header">
					<h4 class="d-inline-block">Edit Package</h4>
				</div>
				<div class="card-body">
					<img id="uploadPreview" alt="{{ $plan->name }}" src="{{ asset($plan->cover) }}" style="width: 100px; height: 100px;border:2px solid #ECF4FF;object-fit: cover;border-radius: 50px;background: #ECF4FF"><br>
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control" value="{{ $plan->name }}" required="">
						<input type="hidden" name="id" value="{{ $plan->id }}" required="">
					</div>
					<div class="form-group">
						<label>Cover</label>
						<input type="file" name="cover" class="form-control">
					</div>
					<div class="form-group">
						<label>Annual Interests</label>
						<input type="number" name="interests" class="form-control" step="any" required="" value="{{ $plan->interests }}">
					</div>
					<div class="form-group">
						<label>Amount</label>
						<input type="number" name="min_invest" class="form-control" step="any" required="" value="{{ $plan->min_invest }}">
					</div>
					<div class="form-group">
						<label>Witholding Tax</label>
						<input type="number" name="witholding_tax" class="form-control" step="any" required="" value="{{ $plan->witholding_tax }}">
					</div>
					<div class="form-group">
						<label>Short Description</label>
						<textarea class="form-control" name="short_desc" required maxlength="100">{!! $plan->short_desc !!}</textarea>
					</div>
					<div class="form-group">
						<label>Description</label>
						<textarea id="textarea" name="description">{!! $plan->description !!}</textarea>
					</div>
					<button class="btn btn-primary btn-block">Edit Plan</button>
				</div>
			</div>
		</form>
		@else
		<form action="{{ route('admin.plans.add') }}" method="post" enctype="multipart/form-data">
			@csrf
			<div class="card">
				<div class="card-header">
					<h4 class="d-inline-block">Add new Package</h4>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control" required="">
					</div>
					<div class="form-group">
						<label>Cover</label>
						<input type="file" name="cover" class="form-control" required="">
					</div>
					<div class="form-group">
						<label>Annual Interests</label>
						<input type="number" name="interests" class="form-control" step="any" required="">
					</div>
					<div class="form-group">
						<label>Minimum Investments</label>
						<input type="number" name="min_invest" class="form-control" step="any" required="">
					</div>
					<div class="form-group">
						<label>Witholding Tax</label>
						<input type="number" name="witholding_tax" class="form-control" step="any" required="">
					</div>
					<div class="form-group">
						<label>Short Description</label>
						<textarea class="form-control" name="short_desc" required maxlength="100"></textarea>
					</div>
					<div class="form-group">
						<label>Description</label>
						<textarea id="textarea" name="description"></textarea>
					</div>
					<button class="btn btn-primary btn-block">Add Plan</button>
				</div>
			</div>
		</form>
		@endif
	</div>
</div>
@endsection

@section('foot')
    <script src="{{ asset('assets_admin/bundles/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets_admin/js/page/ckeditor.js') }}"></script>
@endsection