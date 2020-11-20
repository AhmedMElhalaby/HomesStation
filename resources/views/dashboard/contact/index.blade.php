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
        <h5 class="panel-title"> {{ trans('dash.contacts.contact_us') }} </h5>        
    </div>
    <table class="table table-condensed table-hover datatable-highlight">
        <thead>
            <tr>
                <th class="text-center"> {{ trans('dash.contacts.name') }} </th>
                <th class="text-center"> {{ trans('dash.contacts.mobile') }} </th>
                <th class="text-center"> {{ trans('dash.contacts.title') }} </th>
                <th class="text-center"> {{ trans('dash.contacts.is_seen') }} </th>
                <th class="text-center"> {{ trans('dash.created_at') }} </th>
                <th class="text-center"> {{ trans('dash.actions') }} </th>
            </tr>
        </thead>
        <tbody>
            @forelse($contacts as $contact)
            <tr class="text-center" id="row_{{ $contact->id }}">
                <td> {{ $contact->name }} </td>
                <td> {{ $contact->mobile }} </td>
                <td> {{ $contact->title }} </td>
                <td>
                    @if($contact->seen == '1')
                        <span class="label bg-success-400"> {{ trans('dash.contacts.seen') }} </span>
                    @else
                        <span class="label bg-warning-400"> {{ trans('dash.contacts.unseen') }} </span>
                    @endif
                </td>
                <td> {{ $contact->created_at->diffforhumans() }} </td>
                <td class="text-center">
                    <a href="{{ route('contact.show', $contact->id) }}" class="btn btn-success" data-popup="tooltip" title="{{ trans('dash.show_data') }}"><i class="fa fa-tv"></i></a>
                    <a data-popup="tooltip" title="{{ trans('dash.delete_data') }}" onclick="sweet_delete( '{{ route('contact.destroy', $contact->id) }}', {{ $contact->id }} )" class="btn btn-danger" > <i class="icon-bin2"></i> </a>
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
