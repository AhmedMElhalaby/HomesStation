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
                <th class="text-center"> {{ trans('dash.order') }} </th>
                <th class="text-center"> {{ trans('dash.client_name') }} </th>
                <th class="text-center"> {{ trans('dash.provider_name') }} </th>
                <th class="text-center"> {{ trans('dash.order_price') }} </th>
                <th class="text-center"> {{ trans('dash.delegate_price') }} </th>
                <th class="text-center"> {{ trans('dash.order_status') }} </th>
                <th class="text-center"> {{ trans('dash.created_at') }} </th>
                <th class="text-center"> {{ trans('dash.actions') }} </th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1;?>
            @forelse($orders as $order)
            <tr id="row_{{ $order->id }}">
                <td class="text-center"> {{ $count }} </td>
                <td class="text-center"> <a href="{{url('dashboard/order/'.$order->id.'/show')}}">{{ $order->id }}</a> </td>
                <td class="text-center"> {{ $order->User->username }} </td>
                <td class="text-center"> {{ $order->Provider->username }} </td>
                <td class="text-center"> {{ $order->total_order_price }} </td>
                <td class="text-center"> {{ $order->delivery_price }} </td>
                <td class="text-center">
                    <span class="label bg-success-400">{{ order_status($order->order_status) }}</span>
                </td>
                <td class="text-center"> {{ $order->created_at->diffforhumans() }} </td>
                <td class="text-center">
                    <a data-popup="tooltip" title="{{ trans('dash.edit_data') }}" onclick="sweet_delete( '{{ route('retrieve_order.reply') }}', {{ $order->id }}, 'accept' )" class="btn btn-primary"><i class="icon-checkmark3"></i></a>
                    <a data-popup="tooltip" title="{{ trans('dash.edit_data') }}"  onclick="sweet_delete( '{{ route('retrieve_order.reply') }}', {{ $order->id }}, 'reject' )" class="btn btn-danger"><i class="icon-cross2"></i></a>
                </td>
            </tr>
            <?php $count++;?>
            @empty
            @endforelse
        </tbody>
    </table>
</div>
<script>

    function sweet_delete(url, id, reply)
    {
        $( "#row_"+ id ).css('background-color','#000000').css('color','white');
        $.ajax({
            url: url,
            type: 'post',
            data: {_method: 'put', _token : '{{ csrf_token() }}', order_id: id, reply: reply },
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
    }

    {{--  $('#follow_organization').on('click', function (e) {
        $.ajax({
            type: "get",
            url: "{{ route('app.volunteer_follow_organization') }}",
            data: 'organization_id=' + {{ $organization->id }},
            beforeSend: function (xhr) {
            }, success: function (data) {
                if(data == 'unfollow'){
                    $('.follow').css("display", "inline");
                    $('.following').css("display", "none");
                }else{
                    $('.follow').css("display", "none");
                    $('.following').css("display", "inline");
                }
            }
        });
    });  --}}
</script>
@endsection
