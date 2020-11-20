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
        <h5 class="panel-title"> {{ trans('dash.permissions.permissions') }} </h5>        
    </div>

    <a class="btn btn-primary" href="{{ route('permission.create') }}"> {{ trans('dash.permissions.add_new_permission') }} </a>
    <table class="table table-condensed table-hover datatable-highlight">
        <thead>
            <tr>
                <th class="text-center"> # </th>
                <th class="text-center"> {{ trans('dash.permissions.role_name_ar') }} </th>
                <th class="text-center"> {{ trans('dash.permissions.role_name_en') }} </th>
                <th class="text-center"> {{ trans('dash.created_at') }} </th>
                <th class="text-center"> {{ trans('dash.actions') }} </th>
            </tr>
        </thead>
        <tbody>
            @forelse($permissions as $permission)
            <tr id="row_{{ $permission->id }}">
                <th class="text-center"> {{ $loop->iteration }} </th>
                <th class="text-center"> {{ $permission->role_ar }} </th>
                <th class="text-center"> {{ $permission->role_en }} </th>
                <td class="text-center"> {{ date('Y-m-d H:i', strtotime($permission->created_at)) }} </td>
                <td class="text-center">
                    @if($permission->id > 2)
                        <a href="{{ route('permission.edit',['id' => $permission->id ]) }}" data-popup="tooltip" title="{{ trans('dash.edit_data') }}"  class="btn btn-primary"> <i class="icon-pencil3"></i> </a>
                        <a data-popup="tooltip" title="{{ trans('dash.delete_data') }}" onclick="sweet_delete( '{{ route('permission.destroy', $permission->id) }}', {{ $permission->id }} )" class="btn btn-danger" > <i class="icon-bin2"></i> </a>
                    @else
                        <span class="label bg-danger-400">{{ trans('dash.you_are_not_allowed_to_edit_or_deleted_data_for_this_item') }}</span>
                    @endif
                </td>
            </tr>
            @empty
            @endforelse
            
        </tbody>
    </table>
    <br>
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
