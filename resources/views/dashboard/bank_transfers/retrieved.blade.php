@extends('dashboard.layout')
@section('script')
    <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/core/app.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/pages/datatables_advanced.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/ui/ripple.min.js"></script>
@endsection
@section('content')
<div class="panel panel-flat tb_padd">
    <div class="panel-heading">
        <h5 class="panel-title"> {{ trans('dash.retrieve_orders') }} : {{ trans('dash.retrieve_order_requests') }} </h5>        
    </div>
    <table class="table table-condensed table-hover datatable-highlight">
        <thead>
            <tr>
                <th class="text-center"> # </th>
                <th class="text-center"> {{ trans('dash.client_name') }} </th>
                <th class="text-center"> {{ trans('dash.provider_name') }} </th>
                <th class="text-center"> {{ trans('dash.order_price') }} </th>
                <th class="text-center"> {{ trans('dash.delegate_price') }} </th>
                <th class="text-center"> {{ trans('dash.order_status') }} </th>
                <th class="text-center"> {{ trans('dash.created_at') }} </th>
                {{--  <th class="text-center"> {{ trans('dash.actions') }} </th>  --}}
            </tr>
        </thead>
        <tbody>
            <?php $count = 1;?>
            @forelse($orders as $order)
            <tr id="row_{{ $order->id }}">
                <td class="text-center"> {{ $count }} </td>                
                <td class="text-center"> {{ $order->User->username }} </td>
                <td class="text-center"> {{ $order->Provider->username }} </td>
                <td class="text-center"> {{ $order->total_order_price }} </td>
                <td class="text-center"> {{ $order->delivery_price }} </td>
                <td class="text-center">
                    <span class="label bg-success-400">{{ order_status($order->order_status) }}</span>                    
                </td>
                <td class="text-center"> {{ $order->created_at->diffforhumans() }} </td>
                {{--  <td class="text-center">
                    
                </td>  --}}
            </tr>
            <?php $count++;?>
            @empty
            @endforelse            
        </tbody>
    </table>
</div>
@endsection