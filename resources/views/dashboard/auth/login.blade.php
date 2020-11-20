@extends('dashboard.layout_custom')
@section('style')
<style>
	.content:first-child{
		padding-top: 70px;
	}
</style>
@endsection
@section('content')
    <!-- Page content -->
	<div class="page-content">
		<!-- Main content -->
		<div class="content-wrapper">
			<!-- Content area -->
			<div class="content pb-20">				
				<!-- Form with validation -->
				<form action="{{ route('dashboard.post_login') }}" method="post" class="form-validate">
					{{ csrf_field() }}
					<div class="panel panel-body login-form">							
						@forelse($errors->all() as $message)
						<div class="alert alert-danger" style="direction: rtl;">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							{{ $message }}
						</div> 
						@empty
						@endforelse

						@if (session('message') && session('class') )
						<div style="padding: 5px 25px;direction: rtl;">
							<div class="{{  session('class') }}">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								{{ session('message') }}
							</div>
						</div>
						@endif

						<div class="text-center">
							<div class="icon-object border-slate-300 text-slate-300"><img src="{{ asset('resources/assets/dashboard/material') }}/assets/images/logo-icon.png" style="width: 60px; height: 60px"></div>
							<h5 class="content-group"> {{ trans('dash.login') }} <small class="display-block"> {{ trans('dash.home_station_dashboard') }} </small></h5>
						</div>

						<div class="form-group has-feedback has-feedback-left">
							<input type="email" class="form-control" placeholder="{{ trans('dash.email') }}" name="email" required="required">
							<div class="form-control-feedback">
								<i class="icon-user text-muted"></i>
							</div>
						</div>

						<div class="form-group has-feedback has-feedback-left">
							<input type="password" class="form-control" placeholder="{{ trans('dash.password') }}" name="password" required="required">
							<div class="form-control-feedback">
								<i class="icon-lock2 text-muted"></i>
							</div>
						</div>

						<div class="form-group login-options">
							<div class="row">
								<div class="col-sm-6">
									<label class="checkbox-inline">
										<input type="checkbox" class="styled">
										تذكرنى
									</label>
								</div>

								<div class="col-sm-6 text-right">
									<a href="#">{{ trans('dash.forgot_password') }}  </a>
								</div>
							</div>
						</div>

						<div class="form-group">
							<button type="submit" class="btn bg-blue-400 btn-block"> 
								<i class="icon-arrow-left13 position-right"></i>
								{{ trans('dash.login') }} 
							</button>
						</div> 
				</form>
				<!-- /form with validation -->				
			</div>
			<!-- Footer -->
				<div class="footer text-white text-center">
					<a href="#" class="text-white">{{ trans('dash.copy_write') }}</a>
				</div>
				<!-- /footer -->
			<!-- /content area -->
		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->
@endsection