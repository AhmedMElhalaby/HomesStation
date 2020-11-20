@extends('dashboard.layout')

@section('script')
    {{--  <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/tables/datatables/datatables.min.js"></script>  --}}
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/media/fancybox.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/core/app.js"></script>
	{{--  <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/pages/datatables_advanced.js"></script>  --}}
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/ui/ripple.min.js"></script>
    {{--  <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/pages/components_modals.js"></script>  --}}
@endsection

@section('content')
<!-- Cover area -->
<div class="profile-cover">
    <div class="profile-cover-img" style="background-image: url({{ asset('resources/assets/dashboard/material') }}/assets/images/user_background.jpg)"></div>
    <div class="media">
        <div class="media-left">
            <a class="profile-thumb">
                <img src="{{ $user->profile_image }}" class="img-circle" alt="">
            </a>
        </div>
        <div class="media-body">
            <h1>{{ $user->username }} </h1>
        </div>
        <div class="media-right media-middle">
            <ul class="list-inline list-inline-condensed no-margin-bottom text-nowrap">
                <li><a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary"><i class="icon-pencil3 position-left"></i> {{ trans('dash.edit_data') }} </a></li>
            </ul>
        </div>
    </div>
</div>
<!-- /cover area -->
<!-- Toolbar -->
<div class="navbar navbar-default navbar-xs content-group">
    <ul class="nav navbar-nav visible-xs-block">
        <li class="full-width text-center"><a data-toggle="collapse" data-target="#navbar-filter"><i class="icon-menu7"></i></a></li>
    </ul>
    <div class="navbar-collapse collapse" id="navbar-filter">
        <ul class="nav navbar-nav">
            <li class="active"><a href="#info" data-toggle="tab"><i class="icon-user position-left"></i> {{ trans('dash.main_info') }} </a></li>
            <li><a href="#user_orders" data-toggle="tab"><i class="icon-truck position-left"></i> {{ trans('dash.user_orders') }} </a></li>
            {{--  <li><a href="#statistics" data-toggle="tab"><i class="icon-stats-dots position-left"></i> {{ trans('dash.statistics') }} </a></li>  --}}
        </ul>
    </div>
</div>
<!-- /toolbar -->
<!-- Content area -->
<div class="content">
    <!-- User profile -->
    <div class="row">
        <div class="col-lg-9">
            <div class="tabbable">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="info">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h6 class="panel-title">{{ trans('dash.main_info') }}</h6>                                
                            </div>
			            	<div class="panel-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>{{ trans('dash.username') }}</label>
                                            <input type="text" value="{{ $user->username }}" readonly class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>{{ trans('dash.email') }}</label>
                                            <input type="text" value="{{ $user->email }}" readonly class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>{{ trans('dash.account_type') }}</label>
                                            @if($user->type == 'user')
                                                <input type="text" value="{{ trans('dash.user') }}" readonly class="form-control">
                                            @elseif($user->type == 'provider')
                                                <input type="text" value="{{ trans('dash.provider') }}" readonly class="form-control">
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <label>{{ trans('dash.mobile') }}</label>
                                            <input type="text" value="{{ $user->mobile }}" readonly class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label>{{ trans('dash.city') }}</label>
                                            <input type="text" readonly value="{{ $user->City['name_' . app()->getLocale()] }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>{{ trans('dash.active') }}</label>
                                            @if($user->active == 'active')
                                                <input type="text" value="{{ trans('dash.active') }}" readonly class="form-control">
                                            @elseif($user->active == 'deactive')
                                                <input type="text" value="{{ trans('dash.deactive') }}" readonly class="form-control">
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <label>{{ trans('dash.banned_account') }}</label>
                                            @if($user->banned == '0')
                                                <input type="text" value="{{ trans('dash.not_banned_account') }}" readonly class="form-control">
                                            @elseif($user->banned == '1')
                                                <input type="text" value="{{ trans('dash.banned_account') }}" readonly class="form-control">
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <label>{{ trans('dash.ban_reason') }}</label>
                                            <textarea class="form-control" readonly>{{ $user->ban_reason }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
                    </div>
                    <div class="tab-pane fade" id="user_orders">
                        <div class="row">
                            @forelse($user->UserOrders as $order)
                                <div class="col-lg-3 col-md-6">
                                    <div class="thumbnail no-padding">
                                        <div class="thumb">
                                            <img src="{{ $order->Provider->image400 }}" alt="">
                                            <div class="caption-overflow">
                                                <span>
                                                    <a href="{{ $order->Provider->profile_image }}" class="btn bg-success-400 btn-icon btn-xs" data-popup="lightbox"><i class="fa fa-tv"></i></a>                                                    
                                                    <a href="{{ route('provider.show', $order->provider_id) }}" class="btn bg-success-400 btn-icon btn-xs"><i class="icon-link"></i></a>
                                                </span>
                                            </div>
                                        </div>                                    
                                        <div class="caption text-center">
                                            <h6 class="text-semibold no-margin">
                                                {{ $order->Provider->username }}
                                                <small class="display-block">{{ trans('dash.order_number') }} - {{ $order->id }}</small>
                                                <small class="display-block">{{ $order->created_at->diffforhumans() }}</small>
                                            </h6>
                                            <ul class="icons-list mt-15">
                                                <a href="{{ route('order.show', $order->id) }}" class="btn btn-primary">
                                                    <i class="icon-cog3 position-left"></i>{{ trans('dash.show_data') }}
                                                </a>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-warning no-border">
                                    {{ trans('dash.empty') }}
                                </div>
                            @endforelse
						</div>
                    </div>
                    {{--  <div class="tab-pane fade" id="statistics">
                        <!-- Available hours -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h6 class="panel-title">Available hours</h6>                                
                            </div>
                            <div class="panel-body">
                                <div class="chart-container">
                                    <div class="chart has-fixed-height" id="plans"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /available hours -->
                        <!-- Calendar -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h6 class="panel-title">My schedule</h6>
                                <div class="heading-elements">
                                    <ul class="icons-list">
                                        <li><a data-action="collapse"></a></li>
                                        <li><a data-action="reload"></a></li>
                                        <li><a data-action="close"></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="schedule"></div>
                            </div>
                        </div>
                        <!-- /calendar -->
                    </div>  --}}
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <!-- send notification -->
            <div class="panel border-left-lg border-left-danger invoice-grid timeline-content">
                <div class="panel-heading">
                    <h6 class="panel-title">{{ trans('dash.send_notification') }}</h6>                    
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form action="{{ route('notification.send_single') }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name='user_id' value="{{ $user->id }}" />
                                <div class="form-group">
                                    <textarea name="message" class="form-control mb-15" rows="3" cols="1" placeholder="{{ trans('dash.send_notification') }}"></textarea>
                                </div>
                                <center>
                                    <button type="submit" class="btn btn-danger btn-labeled btn-labeled-right">
                                        {{ trans('dash.send') }}
                                        <b><i class="icon-bell3"></i></b>
                                    </button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /send notification -->
        </div>
    </div>
    <!-- /user profile -->
</div>
<!-- /content area -->
@endsection
@section('custom_script')
<script>
    $(function() {
        // Initialize lightbox
        $('[data-popup=lightbox]').fancybox({
            padding: 3
        });    
    });
</script>
@endsection