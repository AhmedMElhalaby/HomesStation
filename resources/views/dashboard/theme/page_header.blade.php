
<!-- Page header -->
<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<img width="50%" src="{{ asset('resources/assets/dashboard/material/assets/images/header.png')   }}"  />
		</div>

		{{--  <div class="heading-elements">
			<div class="heading-btn-group">
				<a href="#" class="btn btn-link btn-float text-size-small has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
				<a href="#" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
				<a href="#" class="btn btn-link btn-float text-size-small has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
			</div>
		</div>  --}}
	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="{{ route('dashboard.home') }}"><i class="icon-home2 position-left"></i> {{ trans('dash.home') }} </a></li>			
		</ul>

		{{--  <ul class="breadcrumb-elements">
			
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<i class="icon-link position-left"></i>
					{{ trans('dash.quick_links') }}
					<span class="caret"></span>
				</a>

				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="{{ route('user.create') }}"><i class="icon-statistics"></i> {{ trans('dash.add_new_user') }} </a></li>
					<li class="divider"></li>
					<li><a href="{{ route('category.create') }}"><i class="icon-statistics"></i> {{ trans('dash.add_new_category') }} </a></li>
					<li class="divider"></li>
					<li><a href="{{ route('city.create') }}"><i class="icon-accessibility"></i> {{ trans('dash.add_new_city') }} </a></li>
					<li class="divider"></li>
					<li><a href="{{ route('setting') }}"><i class="icon-gear"></i> {{ trans('dash.settings') }} </a></li>
				</ul>
			</li>
		</ul>  --}}
	</div>
</div>
<!-- /page header -->

