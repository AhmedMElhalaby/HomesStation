<!-- Main navbar -->
<div class="navbar navbar-inverse bg-indigo">
	<div class="navbar-header">
		<a class="navbar-brand" target="_blank" href="">
		لوحة تحكم تطبيق هوم استيشن
		<ul class="nav navbar-nav visible-xs-block">
			<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
		</ul>
	</div>
	<div class="navbar-collapse collapse" id="navbar-mobile">
		<ul class="nav navbar-nav">
			<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
		</ul>
		<div class="navbar-right">
			<p class="navbar-text"><span class="label bg-success-400">Online</span></p>				
			<ul class="nav navbar-nav">				
				
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						{{--  <img class="img-circle img-responsive" src="{{ auth()->user()->profile_image }}" alt="">  --}}
						<span> {{ auth()->user()->username }} </span>
						<i class="caret"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="{{ route('admin.profile') }}"><i class="icon-user-plus"></i>{{ trans('dash.my_profile') }}</a></li>
						{{--  <li><a href="#"><i class="icon-coins"></i> My balance</a></li>
						<li><a href="#"><span class="badge badge-warning pull-right">58</span> <i class="icon-comment-discussion"></i> Messages</a></li>  --}}
						<li class="divider"></li>
						<li><a href="{{ route('setting.index') }}"><i class="icon-cog5"></i>{{ trans('dash.settings') }}</a></li>
						<li><a href="{{ route('dashboard.logout') }}"><i class="icon-switch2"></i>{{ trans('dash.logout') }}</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- /main navbar -->