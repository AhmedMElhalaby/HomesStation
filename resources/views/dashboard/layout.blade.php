<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> {{ trans('dash.home_station_dashboard') }}  </title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ asset('resources/assets/dashboard/material') }}/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="{{ asset('resources/assets/dashboard/material') }}/assets/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
	<link href="{{ asset('resources/assets/dashboard/material') }}/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="{{ asset('resources/assets/dashboard/material') }}/assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="{{ asset('resources/assets/dashboard/material') }}/assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="{{ asset('resources/assets/dashboard/material') }}/assets/css/colors.css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="{{ asset('resources/assets/dashboard/material') }}/assets/images/fav.png" type="image/x-icon">
	@if(app()->getLocale() == 'ar')
		<link href="{{ asset('resources/assets/dashboard/material') }}/assets/css/style-rtl.css" rel="stylesheet" type="text/css">
	@else
		<link href="{{ asset('resources/assets/dashboard/material') }}/assets/css/style-rtl.css" rel="stylesheet" type="text/css">
	@endif
	<!-- /global stylesheets -->

    @yield('style')

	<!-- Core JS files -->

	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/sweetalert.min.js"></script>

    @yield('script')
    @yield('custom_script')


</head>

<body>

    @include('dashboard.theme.navbar')
    
	<!-- Page container -->
	<div class="page-container">
        
        <!-- Page content -->
		<div class="page-content">
            
            
            @include('dashboard.theme.sidebar')
            
            
			<!-- Main content -->
			<div class="content-wrapper">

			@if(isset($page_header))
			@include($page_header)
			@else
			@include('dashboard.theme.page_header')
			@endif

            @if (session('message') && session('class') )
            <div style="padding: 5px 25px;direction: rtl;">
				<div class="{{  session('class') }}">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('message') }}
                </div>
            </div>
			@endif

			@if(session('swal') && session('icon'))
			<script>
				swal({
					title: "{{ trans('alert') }}",
					text: "{{ session('swal') }}",
					icon: "{{ session('icon') }}",
					timer:2000
				});
			</script>
			@endif
			
			@forelse($errors->all() as $message)
			<div style="padding: 0px 20px">
				<div class="alert alert-warning">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					{{ $message }}
				</div> 
			</div> 
			@empty
			@endforelse
                            

				<!-- Content area -->
				<div class="content">

                    @yield('content')

					@include('dashboard.theme.footer')
				</div>

				<!-- /content area -->
				
			</div>
			<!-- /main content -->
			
		</div>
		<!-- /page content -->
		
	</div>
	<!-- /page container -->
	
</body>
</html>

