@extends('dashboard.layout')

@section('script')
    <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/media/fancybox.min.js"></script>
    <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/core/app.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/pages/datatables_advanced.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/ui/ripple.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/pages/gallery.js"></script>
@endsection

@section('content')
<!-- Cover area -->
<div class="profile-cover">
    <div class="profile-cover-img" style="background-image: url({{ asset('resources/assets/dashboard/material') }}/assets/images/delivery_background.jpg)"></div>
    <div class="media">
        <div class="media-left">
            <a class="profile-thumb">
                <img src="{{ $delegate->profile_image }}" style="background-color: #fff" class="img-circle" alt="">
            </a>
        </div>

        <div class="media-body">
            <h1> {{ $delegate->username }} </h1>
        </div>

        <div class="media-right media-middle">
            <ul class="list-inline list-inline-condensed no-margin-bottom text-nowrap">
                <li><a href="{{ route('delegate.edit', $delegate->id) }}" class="btn btn-primary"><i class="icon-pencil3 position-left"></i> {{ trans('dash.edit_data') }} </a></li>
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
            <li><a href="#delegate_orders" data-toggle="tab"><i class="icon-truck position-left"></i> {{ trans('dash.delegate_orders') }} </a></li>
            <li><a href="#expire_date" data-toggle="tab"><i class="icon-calendar2 position-left"></i> {{ trans('dash.expire_date_subscription') }} </a></li>
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
                                            <input type="text" value="{{ $delegate->username }}" readonly class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>{{ trans('dash.email') }}</label>
                                            <input type="text" value="{{ $delegate->email }}" readonly class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>{{ trans('dash.account_type') }}</label>
                                            @if($delegate->type == 'user')
                                                <input type="text" value="{{ trans('dash.user') }}" readonly class="form-control">
                                            @elseif($delegate->type == 'delegate')
                                                <input type="text" value="{{ trans('dash.delegate') }}" readonly class="form-control">
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <label>{{ trans('dash.mobile') }}</label>
                                            <input type="text" value="{{ $delegate->mobile }}" readonly class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label>{{ trans('dash.city') }}</label>
                                            <input type="text" readonly value="{{ $delegate->City['name_' . app()->getLocale()] }}" class="form-control">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>{{ trans('dash.active') }}</label>
                                            @if($delegate->active == 'active')
                                                <input type="text" value="{{ trans('dash.active') }}" readonly class="form-control">
                                            @elseif($delegate->active == 'deactive')
                                                <input type="text" value="{{ trans('dash.deactive') }}" readonly class="form-control">
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <label>{{ trans('dash.banned_account') }}</label>
                                            @if($delegate->banned == '0')
                                                <input type="text" value="{{ trans('dash.not_banned_account') }}" readonly class="form-control">
                                            @elseif($delegate->banned == '1')
                                                <input type="text" value="{{ trans('dash.banned_account') }}" readonly class="form-control">
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <label>{{ trans('dash.ban_reason') }}</label>
                                            <textarea class="form-control" readonly>{{ $delegate->ban_reason }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>{{ trans('dash.nationality') }}</label>                                            
                                            <input type="text" value="{{ $delegate->Nationality['name_' . app()->getLocale()] }}" readonly class="form-control">
                                        </div>                                        
                                        <div class="col-md-4">
                                            <label>{{ trans('dash.identity_number') }}</label>
                                            <input type="text" readonly value="{{ $delegate->identity_number }}" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label>{{ trans('dash.license_image') }}</label>
                                            <a href="{{ $delegate->license_image_url }}" data-popup="lightbox">
                                                <img src="{{ $delegate->license_image_url }}" width="100px" alt="" class="img-preview rounded">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
                    </div>
                    <div class="tab-pane fade" id="delegate_orders">
                        <div class="row">
                            @forelse($delegate->DelegateOrders as $order)
                                <div class="col-lg-3 col-md-6">
                                    <div class="thumbnail no-padding">
                                        <div class="thumb">
                                            <img src="{{ $order->User->image400 }}" alt="">
                                            <div class="caption-overflow">
                                                <span>
                                                    <a href="{{ $order->User->profile_image }}" class="btn bg-success-400 btn-icon btn-xs" data-popup="lightbox"><i class="fa fa-tv"></i></a>                                                    
                                                    <a href="{{ route('user.show', $order->user_id) }}" class="btn bg-success-400 btn-icon btn-xs"><i class="icon-link"></i></a>
                                                </span>
                                            </div>
                                        </div>                                    
                                        <div class="caption text-center">
                                            <h6 class="text-semibold no-margin">
                                                {{ $order->User->username }}
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
                    <div class="tab-pane fade" id="expire_date">                        
                        <form action="{{ route('delegate.update_expire_date') }}" class="form-horizontal" method="post">
                            {{ csrf_field() }}
                            <div class="panel panel-flat">
                                <div class="panel-heading">
                                    <h6 class="panel-title">{{ trans('dash.expire_date_subscription') }}</h6>
                                    <div class="heading-elements">
                                        <h6 class="panel-title"> {{ trans('dash.expire_date_subscription') }} : {{ $delegate->expire_date }}</h6>                                        
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label"> {{ trans('dash.expire_date_subscription') }} </label>
                                        <div class="col-lg-9">
                                            <input type="hidden" class="form-control" name="delegate_id" value="{{ $delegate->id }}" required>
                                            <input type="datetime-local" class="form-control" name="expire_date" placeholder="{{ trans('dash.expire_date_subscription') }}" required>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <input type="submit" class="btn btn-primary" name="forward" value=" {{ trans('dash.edit_data') }} " />
                                    </div>
                                </div>
                            </div>
                        </form>                            
                    </div>
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
                                <input type="hidden" name='user_id' value="{{ $delegate->id }}" />
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
<script>
    function sweet_delete(url, id)
    {
        $( "#row_"+ id ).css('background-color','#000000').css('color','white');
        swal({
            title: "{{ trans('dash.deleted_msg_confirm') }}",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {_method: 'delete', _token : '{{ csrf_token() }}' },
                    success: function (data) {
                        console.log(data);
                        if(data['status'] == 'true'){
                            swal({
                                title: "{{ trans('alert') }}",
                                text: data['message'],
                                icon: "success",
                            });
                            $( "#row_" + id ).hide(1000);
                        }else{
                            swal({
                                title: "{{ trans('alert') }}",
                                text: data['message'],
                                icon: "warning",
                            });
                            $("#row_" + id ).removeAttr('style');
                        }
                    }
                });                               
            }else{
                $( "#row_"+id ).removeAttr('style');
            }
        });
    }
</script>
@endsection
