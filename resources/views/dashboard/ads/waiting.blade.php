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
        <h5 class="panel-title"> {{ trans('dash.ads.ads') }} </h5>
    </div>
    <table class="table table-condensed table-hover datatable-highlight">
        <thead>
            <tr>
                <th class="text-center"> # </th>
                <th class="text-center"> {{ trans('dash.ads.image') }} </th>
                <th class="text-center"> {{ trans('dash.provider') }} </th>
                <th class="text-center"> {{ trans('dash.category') }} </th>
                <th class="text-center"> {{ trans('dash.date_day') }} </th>
                <th class="text-center"> {{ trans('dash.ads.status') }} </th>
                <th class="text-center"> {{ trans('dash.ads.desc') }} </th>
                <th class="text-center"> {{ trans('dash.ads.has_paid') }} </th>
                <th class="text-center"> {{ trans('dash.created_at') }} </th>
                <th class="text-center"> {{ trans('dash.actions') }} </th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1;?>
            @forelse($ads as $ad)
            <tr id="row_{{ $ad->id }}">
                <td class="text-center"> {{ $count }} </td>
                <td> <img width="100px" class="img-thumbnail" src="{{ $ad->image400 }}" /> </td>
                <td class="text-center"> <a href="{{ route('provider.show', $ad->user_id) }}"> {{ $ad->User->username }} </a> </td>
                <td class="text-center"> {{ $ad->Category['name_' . app()->getLocale()] }} </td>
                <td class="text-center"> {{ $ad->date_day }} </td>
                <td class="text-center"><span class="badge badge-primary"> {{ trans('dash.ads.waiting') }} </span></td>
                <td class="text-center"> {{ $ad->desc }} </td>
                @php
                    $bt = \App\Models\BankTransfer::where('type','pay_advertising_fees')->where('type_id',$ad->id)->first();
                    $tr = \App\Models\Transactions::where('type','pay_advertising_fees')->where('type_id',$ad->id)->first();
                    if($bt || $tr){
                        $has_paid = '<span class="label bg-success-400">مدفوع</span>';
                    }else{
                        $has_paid = '<span class="label bg-danger-400">غير مدفوع</span>';
                    }
                @endphp
                <td class="text-center"> {!! $has_paid !!} </td>
                <td class="text-center"> {{ $ad->created_at->diffforhumans() }} </td>
                <td class="text-center">
                    <a data-popup="tooltip" title="{{ trans('dash.edit_data') }}" onclick="sweet_delete( '{{ route('ads.reply') }}', {{ $ad->id }}, 'accept' )" class="btn btn-primary"><i class="icon-checkmark3"></i></a>
                    <a data-popup="tooltip" title="{{ trans('dash.edit_data') }}"  onclick="sweet_delete( '{{ route('ads.reply') }}', {{ $ad->id }}, 'reject' )" class="btn btn-danger"><i class="icon-cross2"></i></a>
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
        swal({
            title: "هل أنت متأكد من الأمر ؟",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {_method: 'put', _token : '{{ csrf_token() }}', ads_id: id, reply: reply },
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
