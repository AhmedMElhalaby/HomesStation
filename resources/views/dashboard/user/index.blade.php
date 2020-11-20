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
        <h5 class="panel-title"> {{ trans('dash.users') }} </h5>        
    </div>
    <a class="btn btn-primary" href="{{ route('user.create') }}"> {{ trans('dash.add_new_user') }} </a>
    <a class="btn btn-success" data-toggle="modal" data-target="#myModal"> <i class="icon-bell3"></i> إرسال إشعار لكل المستخدمين </a>
    <table class="table table-condensed table-hover datatable-highlight">
        <thead>
            <tr>
                <th class="text-center"> {{ trans('dash.image') }} </th>
                <th class="text-center"> {{ trans('dash.username') }} </th>
                <th class="text-center"> {{ trans('dash.mobile') }} </th>
                <th class="text-center"> {{ trans('dash.status_account') }} </th>
                <th class="text-center"> {{ trans('dash.city') }} </th>
                <th class="text-center"> {{ trans('dash.created_at') }} </th>
                <th class="text-center"> {{ trans('dash.actions') }} </th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr id="row_{{ $user->id }}">
                <td class="text-center"> <img width="100px" class="img-thumbnail" src="{{ $user->image400 }}" /> </td>
                <td class="text-center"> {{ $user->username }} </td>
                <td class="text-center"> {{ $user->mobile }} </td>
                <td class="text-center">
                    @if($user->banned == '1') 
                        <span class="label bg-warning-400">{{ trans('dash.banned_account') }}</span> 
                    @elseif($user->active == 'deactive')
                        <span class="label bg-danger-400">{{ trans('dash.deactive') }}</span> 
                    @else
                        <span class="label bg-primary-400">{{ trans('dash.active') }}</span> 
                    @endif
                </td>
                <td class="text-center"> {{ $user->City == null ? trans('dash.empty') : $user->City['name_'. app()->getLocale()] }} </td>
                <td class="text-center"> {{ $user->created_at->diffforhumans() }} </td>
                <td class="text-center">
                    <a href="{{ route('user.show', $user->id) }}" class="btn btn-success" data-popup="tooltip" title="{{ trans('dash.show_data') }}"><i class="fa fa-tv"></i></a>
                    <a href="{{ route('user.edit',['id' => $user->id ]) }}" data-popup="tooltip" title="{{ trans('dash.edit_data') }}"  class="btn btn-primary"> <i class="icon-pencil3"></i> </a>
                    {{--  <a data-popup="tooltip" title="archive" class="btn btn-info" > <i class="fa fa-archive"></i> </a>  --}}
                    <a data-popup="tooltip" title="{{ trans('dash.delete_data') }}" onclick="sweet_delete( '{{ route('user.destroy', $user->id) }}', {{ $user->id }} )" class="btn btn-danger" > <i class="icon-bin2"></i> </a>
                </td>
            </tr>
            @empty
            @endforelse
            
        </tbody>
    </table>
    <br>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">إرسال إشعار</h4>
        </div>
        <form action="{{ route('notification.send_multiple') }}" method="POST">
            <div class="modal-body">
                {{ csrf_field() }}
                <input type="hidden" name='type' value="user" />
                <div class="form-group">
                    <textarea name="message" class="form-control mb-15" rows="3" cols="1" placeholder="{{ trans('dash.send_notification') }}"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-labeled btn-labeled-right">{{ trans('dash.send') }}<b><i class="icon-bell3"></i></b></button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
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
