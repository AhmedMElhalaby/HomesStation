@extends('dashboard.layout')

@section('script')
    <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/core/libraries/jasny_bootstrap.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/ui/fullcalendar/fullcalendar.min.js"></script>
	{{--  <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/visualization/echarts/echarts.js"></script>  --}}

	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/core/app.js"></script>
	{{--  <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/pages/user_profile_tabbed.js"></script>  --}}

	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/ui/ripple.min.js"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-3">
        <!-- Detached sidebar -->
        <div class="sidebar-content">
            <!-- User details -->
            <div class="content-group">
                <div class="panel-body bg-indigo-400 border-radius-top text-center" style="background-image: url({{ asset('resources/assets/dashboard/material') }}/assets/images/bg.jpg); background-size: contain;">
                    <div class="content-group-sm">
                        <h6 class="text-semibold no-margin-bottom">
                            {{ $user->username }}
                        </h6>
                        <span class="display-block">{{ $user->Role['role_' . app()->getLocale()] }}</span>
                    </div>
                    <a class="display-inline-block content-group-sm">
                        <img src="{{ $user->profile_image }}" class="img-circle img-responsive" alt="" style="width: 110px; height: 110px;">
                    </a>                    
                </div>

                <div class="list-group panel no-border no-padding-top">
                    <a href="{{ route('user.edit', $user->id) }}" class="list-group-item"><i class="icon-pencil3"></i>{{ trans('dash.edit_data') }}</a>
                    <a href="#" class="list-group-item"><i class="icon-cash3"></i> Balance</a>
                    <a href="#" class="list-group-item"><i class="icon-tree7"></i> Connections <span class="badge bg-danger pull-right">29</span></a>
                    <a href="#" class="list-group-item"><i class="icon-users"></i> Friends</a>
                    <div class="list-group-divider"></div>
                    <a href="#" class="list-group-item"><i class="icon-calendar3"></i> Events <span class="badge bg-teal-400 pull-right">48</span></a>
                    <a href="#" class="list-group-item"><i class="icon-cog3"></i> Account settings </a>
                </div>
            </div>
            <!-- /user details -->

            <!-- Latest updates -->
            <div class="sidebar-category panel">
                <div class="category-title">
                    <span>{{ trans('dash.latest_events') }}</span>
                    <ul class="icons-list">
                        <li><a href="#" data-action="collapse"></a></li>
                    </ul>
                </div>

                <div class="category-content">
                    <ul class="media-list">
                        @forelse($user->Reports as $report)                      
                            <li class="media">
                                <div class="media-left">
                                    <a href="#" class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-pull-request"></i></a>
                                </div>

                                <div class="media-body">
                                    {{ $report->event }}
                                    <div class="media-annotation">{{ $report->created_at->diffforhumans() }}</div>
                                </div>
                            </li>
                        @empty
                            <div class="alert alert-info alert-styled-right alert-dismissible">
                                {{ trans('dash.empty') }}
                            </div>
                        @endforelse                        
                    </ul>
                </div>
            </div>
            <!-- /latest updates -->
        </div>
        <!-- /detached sidebar -->
    </div>
    <div class="col-lg-9">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel bg-brown-700">
                    <div class="panel-body">
                        <h3 class="no-margin"> {{ $user->Paintings()->avaliable()->where('type', 'selling')->count() }} </h3>
                        <h5> اللوح المعروضة للبيع </h5>                        
                    </div>                    
                </div>
            </div>
            <div class="col-lg-4">          
                <div class="panel bg-success-400">
                    <div class="panel-body">
                        <h3 class="no-margin"> {{ $user->Paintings()->avaliable()->where('type', 'bidding')->count() }} </h3>
                        <h5> اللوح المعروضة في مزايدة </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">          
                <div class="panel bg-indigo-600">
                    <div class="panel-body">
                        <h3 class="no-margin"> {{ $user->Paintings()->where(['is_sold' => 'available', 'is_accepted' => 'wait'])->count() }} </h3>
                        <h5> اللوح في إنتظار موافقة الأدمن </h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            
        </div>
    </div>
</div>

@endsection
