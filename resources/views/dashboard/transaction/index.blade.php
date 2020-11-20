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
        <h5 class="panel-title"> {{ trans('dash.transaction.transactions') }} </h5>        
    </div>
    <table class="table table-condensed table-hover datatable-highlight">
        <thead>
            <tr>
                <th class="text-center"> # </th>
                <th class="text-center"> {{ trans('dash.transaction.client_name') }} </th>
                <th class="text-center"> سبب التحويل </th>
                <th class="text-center"> {{ trans('dash.transaction.transaction_id') }} </th>
                <th class="text-center"> {{ trans('dash.transaction.amount') }} </th>
                <th class="text-center"> {{ trans('dash.created_at') }} </th>
                <th class="text-center"> {{ trans('dash.actions') }} </th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1;?>
            @forelse($transactions as $transaction)
            <tr id="row_{{ $transaction->id }}">
                <td class="text-center"> {{ $count }} </td>
                <td class="text-center"> <a href="{{ route('user.show', $transaction->user_id) }}"> {{ $transaction->User->username }} </a> </td>
                <td class="text-center"> 
                    @if($transaction->type == 'pay_of_the_provider_subscription')
                        قيمة اشتراك لمقدم الخدمة
                    @elseif($transaction->type == 'pay_advertising_fees')
                        قيمة عرض إعلان
                    @elseif($transaction->type == 'pay_of_the_delegate_subscription')
                        قيمة اشتراك لمندوب
                    @endif
                </td>
                <td class="text-center"> {{ $transaction->transaction_id }} </td>
                <td class="text-center"> {{ $transaction->amount }} </td>
                <td class="text-center"> {{ $transaction->created_at->diffforhumans() }} </td>
                <td class="text-center">
                    <a data-popup="tooltip" title="{{ trans('dash.delete_data') }}" onclick="sweet_delete( '{{ route('transaction.destroy', $transaction->id) }}', {{ $transaction->id }} )" class="btn btn-danger" > <i class="icon-bin2"></i> </a>
                </td>
            </tr>
            <?php $count++;?>
            @empty
            @endforelse            
        </tbody>
    </table>
</div>

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