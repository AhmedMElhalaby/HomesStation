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
        <h5 class="panel-title"> {{ trans('dash.bank_accounts.bank_accounts') }} </h5>        
    </div>

    <a class="btn btn-primary" href="{{ route('bank_account.create') }}"> {{ trans('dash.bank_accounts.add_new_bank_account') }} </a>

    <table class="table table-condensed table-hover datatable-highlight">
        <thead>
            <tr>
                <th class="text-center"> # </th>
                <th class="text-center"> {{ trans('dash.bank_accounts.logo_bank') }} </th>
                <th class="text-center"> {{ trans('dash.bank_accounts.bank_name') }} </th>
                <th class="text-center"> {{ trans('dash.bank_accounts.owner_account') }} </th>
                <th class="text-center"> {{ trans('dash.bank_accounts.account_number') }} </th>
                <th class="text-center"> {{ trans('dash.created_at') }} </th>
                <th class="text-center"> {{ trans('dash.actions') }} </th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1;?>
            @forelse($bank_accounts as $bank_account)
            <tr id="row_{{ $bank_account->id }}">
                <td class="text-center"> {{ $count }} </td>
                <td> <img width="100px" class="img-thumbnail" src="{{ $bank_account->logo_bank400 }}" /> </td>
                <td class="text-center"> {{ $bank_account->bank_name }} </td>
                <td class="text-center"> {{ $bank_account->owner_account }} </td>
                <td class="text-center"> {{ $bank_account->account_number }} </td>
                <td class="text-center"> {{ $bank_account->created_at->diffforhumans() }} </td>
                <td class="text-center">
                    <a data-popup="tooltip" title="{{ trans('dash.edit_data') }}" href="{{ route('bank_account.edit',['id' => $bank_account->id ]) }}" class="btn btn-primary"> <i class="icon-pencil3"></i> </a>
                    <a data-popup="tooltip" title="{{ trans('dash.delete_data') }}" onclick="sweet_delete( '{{ route('bank_account.destroy', $bank_account->id) }}', {{ $bank_account->id }} )" class="btn btn-danger" > <i class="icon-bin2"></i> </a>
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