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
        <h5 class="panel-title"> {{ trans('dash.providers') }} </h5>        
    </div>
    <a class="btn btn-primary" href="{{ route('provider.create') }}"> {{ trans('dash.add_new_provider') }} </a>
    <a class="btn btn-success" data-toggle="modal" data-target="#myModal"> <i class="icon-bell3"></i> إرسال إشعار لكل مقدمي الخدمات </a>
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
            @forelse($providers as $provider)
            <tr id="row_{{ $provider->id }}">
                <td class="text-center"> <img width="100px" class="img-thumbnail" src="{{ $provider->image400 }}" /> </td>
                <td class="text-center"> {{ $provider->username }} </td>
                <td class="text-center"> {{ $provider->mobile }} </td>
                <td class="text-center">
                    @if($provider->banned == '1') 
                        <span class="label bg-warning-400">{{ trans('dash.banned_account') }}</span> 
                    @elseif($provider->active == 'deactive')
                        <span class="label bg-danger-400">{{ trans('dash.deactive') }}</span> 
                    @else
                        <span class="label bg-success-400">{{ trans('dash.active') }}</span> 
                    @endif
                </td>
                <td class="text-center"> {{ $provider->City == null ? trans('dash.empty') : $provider->City['name_' . app()->getLocale()] }} </td>
                <td class="text-center"> {{ $provider->created_at->diffforhumans() }} </td>
                <td class="text-center">
                    <a href="{{ route('provider.services', $provider->id) }}" class="btn btn-success" data-popup="tooltip" title="{{ trans('dash.provider_services') }}"><i class="icon-cup2"></i></a>
                    <a href="{{ route('provider.show', $provider->id) }}" class="btn btn-success" data-popup="tooltip" title="{{ trans('dash.show_data') }}"><i class="fa fa-tv"></i></a>
                    <a href="{{ route('provider.edit',['id' => $provider->id ]) }}" data-popup="tooltip" title="{{ trans('dash.edit_data') }}"  class="btn btn-primary"> <i class="icon-pencil3"></i> </a>
                    {{--  <a data-popup="tooltip" title="archive" class="btn btn-info" > <i class="fa fa-archive"></i> </a>  --}}
                    <a data-popup="tooltip" title="{{ trans('dash.delete_data') }}" onclick="sweet_delete( '{{ route('provider.destroy', $provider->id) }}', {{ $provider->id }} )" class="btn btn-danger" > <i class="icon-bin2"></i> </a>
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
                <input type="hidden" name='type' value="provider" />
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
