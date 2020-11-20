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
        <h5 class="panel-title"> {{ trans('dash.subscription.subscriptions') }} </h5>        
    </div>

    <a class="btn btn-primary" href="{{ route('subscription.create') }}"> {{ trans('dash.subscription.add_new_subscription') }} </a>

    <table class="table table-condensed table-hover datatable-highlight">
        <thead>
            <tr class="text-center">
                <th> # </th>
                <th>{{ trans('dash.subscription.name_ar') }}</th>
                <th>{{ trans('dash.subscription.name_en') }}</th>
                <th>{{ trans('dash.subscription.user_type') }}</th>
                <th>{{ trans('dash.subscription.period') }}</th>
                <th>{{ trans('dash.subscription.period_type') }}</th>
                <th>{{ trans('dash.subscription.price') }}</th>
                <th> {{ trans('dash.actions') }} </th>
                <th> {{ trans('dash.created_at') }} </th>
            </tr>
        </thead>
        <tbody>
            @forelse($subscriptions as $subscription)
            <tr class="text-center" id="row_{{ $subscription->id }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $subscription->name_ar }}</td>
                <td>{{ $subscription->name_en }}</td>
                <td>{{ $subscription->user_type }}</td>
                <td>{{ $subscription->period }}</td>
                <td>                            
                    @if($subscription->period_type == 'hours')
                        <span class="badge badge-primary">{{ trans('dash.subscription.period_types.hours') }}</span>
                    @elseif($subscription->period_type == 'days')
                        <span class="badge badge-secondary">{{ trans('dash.subscription.period_types.days') }}</span>
                    @elseif($subscription->period_type == 'weeks')
                        <span class="badge badge-warning">{{ trans('dash.subscription.period_types.weeks') }}</span>
                    @elseif($subscription->period_type == 'months')
                        <span class="badge badge-info">{{ trans('dash.subscription.period_types.months') }}</span>
                    @else
                        <span class="badge badge-success">{{ trans('dash.subscription.period_types.years') }}</span>
                    @endif
                </td>
                <td>{{ $subscription->price }}</td>
                <td>{{ $subscription->created_at->diffforHumans() }}</td>
                <td>
                    <a href="{{ route('subscription.edit',['id' => $subscription->id ]) }}" data-popup="tooltip" title="{{ trans('dash.edit_data') }}"  class="btn btn-primary"> <i class="icon-pencil3"></i> </a>
                    <a data-popup="tooltip" title="{{ trans('dash.delete_data') }}" onclick="sweet_delete( '{{ route('subscription.destroy', $subscription->id) }}', {{ $subscription->id }} )" class="btn btn-danger" > <i class="icon-bin2"></i> </a>
                </td>
            </tr>
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