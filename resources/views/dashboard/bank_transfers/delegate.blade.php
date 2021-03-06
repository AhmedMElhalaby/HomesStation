@extends('dashboard.layout')
@section('script')
    <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/media/fancybox.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/core/app.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/pages/datatables_advanced.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/ui/ripple.min.js"></script>
@endsection
@section('content')
<div class="panel panel-flat tb_padd">
    <div class="panel-heading">
        <h5 class="panel-title"> {{ trans('dash.bank_transfers.bank_transfers') }} : {{ trans('dash.bank_transfers.bank_transfers_for_delegate') }} </h5>        
    </div>
    <table class="table table-condensed table-hover datatable-highlight">
        <thead>
            <tr>
                <th class="text-center"> # </th>
                <th class="text-center"> {{ trans('dash.image') }} </th>
                <th class="text-center"> {{ trans('dash.provider') }} </th>
                <th class="text-center"> {{ trans('dash.bank_accounts.bank_name') }} </th>
                <th class="text-center"> {{ trans('dash.bank_accounts.owner_account') }} </th>
                <th class="text-center"> {{ trans('dash.bank_accounts.account_number') }} </th>
                <th class="text-center"> {{ trans('dash.bank_transfers.amount_of_transfer') }} </th>
                <th class="text-center"> {{ trans('dash.sent_at') }} </th>
                <th class="text-center"> {{ trans('dash.actions') }} </th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1;?>
            @forelse($bank_transfers as $bank_transfer)
            <tr id="row_{{ $bank_transfer->id }}">
                <td class="text-center"> {{ $count }} </td>                
                <td class="text-center"> 
                    <a href="{{ $bank_transfer->image600 }}" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round" data-popup="lightbox" rel="group">										
                        <img class="card-img img-fluid img-thumbnail" width="100px" src="{{ $bank_transfer->image200 }}" alt="">
					</a>
                </td>
                <td class="text-center"> {{ $bank_transfer->User->username }} </td>
                <td class="text-center"> {{ $bank_transfer->bank_name }} </td>
                <td class="text-center"> {{ $bank_transfer->owner_account }} </td>                
                <td class="text-center"> {{ $bank_transfer->account_number }} </td>                
                <td class="text-center"> {{ $bank_transfer->amount_of_transfer }} </td>                
                <td class="text-center"> {{ $bank_transfer->created_at->diffforhumans() }} </td>
                <td class="text-center">                    
                    <a data-popup="tooltip" title="{{ trans('dash.edit_data') }}" onclick="sweet_delete( '{{ route('bank_transfer.retrieve') }}', {{ $bank_transfer->id }}, 'accept' )" class="btn btn-primary"><i class="icon-checkmark3"></i></a>
                    <a data-popup="tooltip" title="{{ trans('dash.edit_data') }}"  onclick="sweet_delete( '{{ route('bank_transfer.retrieve') }}', {{ $bank_transfer->id }}, 'reject' )" class="btn btn-danger"><i class="icon-cross2"></i></a>
                </td>
            </tr>
            <?php $count++;?>
            @empty
            @endforelse
        </tbody>
    </table>
</div>
<script>

    $('[data-popup="lightbox"]').fancybox({
        padding: 3
    });

    function sweet_delete(url, id, reply)
    {
        $( "#row_"+ id ).css('background-color','#000000').css('color','white');
        $.ajax({
            url: url,
            type: 'post',
            data: {_method: 'put', _token : '{{ csrf_token() }}', bank_transfer_id: id, reply: reply },
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