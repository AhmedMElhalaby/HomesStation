@extends('dashboard.layout')
@section('script')
    <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/core/app.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/pages/datatables_advanced.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/ui/ripple.min.js"></script>
@endsection
@section('content')
<div class="container-detached">
	<div class="content-detached">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h6 class="panel-title">{{ trans('dash.client_data') }}</h6>
                        <div class="heading-elements">
                            <div class="text-right">
                                <a href="{{ route('user.show', $order->user_id) }}" class="btn btn-success" data-popup="tooltip" title="{{ trans('dash.show_data') }}"><i class="fa fa-tv"></i></a>
                                <a data-popup="tooltip" title="{{ trans('dash.edit_data') }}" href="{{ route('user.edit',['id' => $order->user_id ]) }}" class="btn btn-primary"> <i class="icon-pencil3"></i> </a>
                            </div>
                        </div>
                    </div>
                    <div class="media panel-body no-margin">
                        <div class="media-left">
                            <a href="#">
                                <img src="{{ $order->User->image400 }}" style="width: 100px; height: 100px;" class="img-square" alt="">
                            </a>
                        </div>
                        <div class="media-body">
                            <h5 class="media-heading text-semibold">{{ trans('dash.client_name') }} : {{ $order->User->username }}</h5>
                            <h6 class="text-semibold">{{ trans('dash.mobile') }} : {{ $order->User->mobile }}</h6>                            
                            <h6 class="text-semibold">{{ trans('dash.city') }} : {{ $order->User->City['name_' . app()->getLocale()] }}</h6>                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h6 class="panel-title">{{ trans('dash.provider_data') }}</h6>

                        <div class="heading-elements">
                            <div class="text-right">
                                <a href="{{ route('provider.show', $order->provider_id) }}" class="btn btn-success" data-popup="tooltip" title="{{ trans('dash.show_data') }}"><i class="fa fa-tv"></i></a>
                                <a data-popup="tooltip" title="{{ trans('dash.edit_data') }}" href="{{ route('provider.edit',['id' => $order->provider_id ]) }}" class="btn btn-primary"> <i class="icon-pencil3"></i> </a>
                            </div>
                        </div>
                    </div>
                    <div class="media panel-body no-margin">
                        <div class="media-left">
                            <a href="#">
                                <img src="{{ $order->provider->image400 }}" style="width: 100px; height: 100px;" class="img-square" alt="">
                            </a>
                        </div>
                        <div class="media-body">
                            <h5 class="media-heading text-semibold">{{ trans('dash.provider_name') }} : {{ $order->Provider->username }}</h5>
                            <h6 class="text-semibold">{{ trans('dash.mobile') }} : {{ $order->Provider->mobile }}</h6>                            
                            <h6 class="text-semibold">{{ trans('dash.city') }} : {{ $order->Provider->City['name_' . app()->getLocale()] }}</h6>                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h6 class="panel-title">{{ trans('dash.delegate_data') }}</h6>
                        @if($order->Delegate)
                        <div class="heading-elements">
                            <div class="text-right">
                                <a href="{{ route('delegate.show', $order->delegate_id) }}" class="btn btn-success" data-popup="tooltip" title="{{ trans('dash.show_data') }}"><i class="fa fa-tv"></i></a>
                                <a data-popup="tooltip" title="{{ trans('dash.edit_data') }}" href="{{ route('delegate.edit',['id' => $order->delegate_id ]) }}" class="btn btn-primary"> <i class="icon-pencil3"></i> </a>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="media panel-body no-margin">
                        @if($order->Delegate)
                            <div class="media-left">
                                <a href="#">
                                    <img src="{{ $order->Delegate->image400 }}" style="width: 100px; height: 100px;" class="img-square" alt="">
                                </a>
                            </div>
                            <div class="media-body">
                                <h5 class="media-heading text-semibold">اسم المندوب : {{ $order->Delegate->username }}</h5>
                                <h6 class="text-semibold">{{ trans('dash.mobile') }} : {{ $order->Delegate->mobile }}</h6>                            
                                <h6 class="text-semibold">{{ trans('dash.city') }} : {{ $order->Delegate->City['name_' . app()->getLocale()] }}</h6>                            
                            </div>
                        @else
                            <div class="alert alert-warning no-border">
                                {{ trans('dash.empty') }}
                            </div>
                        @endif
                    </div>
                </div>                
            </div>
            <div class="col-md-12">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h6 class="panel-title">{{ trans('dash.order_details') }}</h6>
                        <div class="heading-elements">
                            <div class="text-right">
                                {{ trans('dash.statistics.total_orders_price') }} : {{ $order->total_order_price }}
                            </div>
                        </div>
                    </div>
                    @if($order->order_category_type == 'products')
                        @foreach($order->OrderServices as $order_service)
                        <div class="media panel-body no-margin">
                            <div class="media-left">
                                <a href="#">
                                    <img src="{{ $order_service->Service->Images->count() > 0 ? $order_service->Service->Images[0]->image400 : asset('storage/app/uploads/default.png') }}" style="width: 100px; height: 100px;" class="img-square" alt="">
                                </a>
                            </div>
                            <div class="media-body">
                                <h5 class="media-heading text-semibold">اسم الخدمة : {{ $order_service->Service->name }}</h5>
                                <h6 class="text-semibold">سعر الخدمة : {{ $order_service->service_price }}</h6>
                                <h6 class="text-semibold">الكمية : {{ $order_service->count }}</h6>
                                <h6 class="text-semibold">السعر الكلي : {{ $order_service->total_price }}</h6>
                                <h5><b>إضافات</b></h5>
                                @if($order_service->AdditionOrderService->count() > 0)
                                    <table class="table table-bordered table-condensed table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center"> # </th>
                                                <th class="text-center"> الاسم </th>
                                                <th class="text-center"> سعر القطعة </th>
                                                <th class="text-center"> الكمية </th>
                                                <th class="text-center"> السعر الكلي </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order_service->AdditionOrderService as $addition_order)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $addition_order->Addition->name }}</td>
                                                <td class="text-center">{{ $addition_order->addition_service_price }}</td>
                                                <td class="text-center">{{ $addition_order->count }}</td>
                                                <td class="text-center">{{ $addition_order->total_price }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="alert alert-warning no-border">
                                        {{ trans('dash.empty') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="media panel-body no-margin">
                            <div class="media-left">
                                <a href="#">
                                    <img src="{{ $order->User->image400 }}" style="width: 100px; height: 100px;" class="img-square" alt="">
                                </a>
                            </div>
                            <div class="media-body">
                                <h5 class="media-heading text-semibold">{{ trans('dash.client_name') }} : {{ $order->User->username }}</h5>
                                <h6 class="text-semibold">{{ trans('dash.mobile') }} : {{ $order->User->mobile }}</h6>                            
                                <h6 class="text-semibold">{{ trans('dash.city') }} : {{ $order->User->City['name_' . app()->getLocale()] }}</h6>                            
                                <h5><b>إضافات</b></h5>
                                <table class="table table-bordered table-condensed table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center"> # </th>
                                            <th class="text-center"> الاسم </th>
                                            <th class="text-center"> الكمية </th>
                                            <th class="text-center"> السعر </th>
                                            <th class="text-center"> السعر الكلي </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">باهر</td>
                                            <td class="text-center"> 5 </td>
                                            <td class="text-center"> 10 </td>
                                            <td class="text-center">
                                            50
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection