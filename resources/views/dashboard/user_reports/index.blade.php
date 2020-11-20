@section('style')
    <style>
        td{
            position: relative;
        }
        td a{
            display: block;
        }
        .popup{
            position:absolute;
            display: none;
            background-color: #ddd;
            width: 100%;
            right: 0;
            left: 0;
            padding: 15px;
            top: 100%;
            z-index: 9;
        }
        .popup img{
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
    </style>
@endsection
@extends('dashboard.layout')

@section('script')
    <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/core/app.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/pages/datatables_advanced.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/ui/ripple.min.js"></script>
    <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/pages/components_popups.js"></script>
    <script>
        $(document).ready(function(){
            $('td').hover(function(){
                $(this).find('.popup').fadeIn();
            });
            $('td').mouseleave(function(){
                $(this).find('.popup').fadeOut();
            });
        });
    </script>
@endsection

@section('content')
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title"> {{ trans('dash.user_reports.user_reports') }} </h5>        
    </div>
    <div class="panel-body">
        <ul class="nav nav-tabs text-center">
            <li class="active col-md-6"><a data-toggle="tab" href="#providers">{{ trans('dash.user_reports.providers') }}</a></li>
            <li class="col-md-6"><a data-toggle="tab" href="#services">{{ trans('dash.user_reports.services') }}</a></li>
            {{--  <li class="col-md-4"><a data-toggle="tab" href="#orders">{{ trans('dash.user_reports.orders') }}</a></li>  --}}
        </ul>
        <div class="tab-content">
            <div id="providers" class="tab-pane fade in active">
                <table class="table table-condensed table-hover datatable-highlight">
                    <thead>
                        <tr>
                            <th class="text-center"> # </th>
                            <th class="text-center"> {{ trans('dash.user') }} </th>
                            <th class="text-center"> {{ trans('dash.provider') }} </th>
                            <th class="text-center"> {{ trans('dash.user_reports.reason') }} </th>
                            <th class="text-center"> {{ trans('dash.sent_at') }} </th>
                            <th class="text-center"> {{ trans('dash.actions') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1;?>
                        @forelse($user_reports_for_providers as $report)
                        <tr id="row_{{ $report->id }}">
                            <td class="text-center"> {{ $count }} </td>
                            <td class="text-center"> 
                                <a class="show-popup" href="{{ route('user.show', $report->user_id) }}"> {{ $report->User->username }} </a> 
                                <div class="popup">
                                    <img src="{{ $report->User->profile_image }}">
                                    <h5>{{ $report->User->username }}</h5>
                                    <a href="{{ route('user.show', $report->user_id) }}">{{ trans('dash.show_data') }}</a>
                                </div>
                            </td>
                            <td class="text-center"> 
                                @if($report->KeyData)
                                    <a class="show-popup" href="{{ route('provider.show', $report->key_id) }}"> {{ $report->KeyData->username }} </a> 
                                    <div class="popup">
                                        <img src="{{ $report->KeyData->profile_image }}">
                                        <h5>{{ $report->KeyData->username }}</h5>
                                        <a href="{{ route('provider.show', $report->key_id) }}">{{ trans('dash.show_data') }}</a>
                                    </div>
                                @else
                                    بيانات محذوفة    
                                @endif
                            </td>
                            <td class="text-center"> {{ $report->reason }} </td>
                            <td class="text-center"> {{ $report->created_at->diffforhumans() }} </td>
                            <td class="text-center">
                                <a href="{{ route('user_reports.show', $report->id) }}" class="btn btn-success" data-popup="tooltip" title="{{ trans('dash.show_data') }}"><i class="fa fa-tv"></i></a>
                                <a data-popup="tooltip" title="{{ trans('dash.delete_data') }}" onclick="sweet_delete( '{{ route('user_reports.destroy', $report->id) }}', {{ $report->id }} )" class="btn btn-danger" > <i class="icon-bin2"></i> </a>
                            </td>
                        </tr>
                        <?php $count++;?>
                        @empty
                        @endforelse
                        
                    </tbody>
                </table>
            </div>
            <div id="services" class="tab-pane fade">
                <table class="table table-condensed table-hover datatable-highlight">
                    <thead>
                        <tr>
                            <th class="text-center"> # </th>
                            <th class="text-center"> {{ trans('dash.user') }} </th>
                            <th class="text-center"> {{ trans('dash.service') }} </th>
                            <th class="text-center"> {{ trans('dash.user_reports.reason') }} </th>
                            <th class="text-center"> {{ trans('dash.sent_at') }} </th>
                            <th class="text-center"> {{ trans('dash.actions') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1;?>
                        @forelse($user_reports_for_services as $report)
                        <tr id="row_{{ $report->id }}">
                            <td class="text-center"> {{ $count }} </td>
                            <td class="text-center"> 
                                <a class="show-popup" href="{{ route('user.show', $report->user_id) }}"> {{ $report->User->username }} </a> 
                                <div class="popup">
                                    <img src="{{ $report->User->profile_image }}">
                                    <h5>{{ $report->User->username }}</h5>
                                    <a href="{{ route('user.show', $report->user_id) }}">{{ trans('dash.show_data') }}</a>
                                </div>
                            </td>
                            <td class="text-center"> 
                                @if($report->KeyData)
                                    <a class="show-popup"> {{ $report->KeyData->name }} </a> 
                                    <div class="popup">
                                        <img src="{{ $report->KeyData->Images[0]->image400 }}">
                                        <h5>{{ $report->KeyData->name }}</h5>
                                    </div>
                                @else
                                    بيانات محذوفة    
                                @endif
                            </td>
                            <td class="text-center"> {{ $report->reason }} </td>
                            <td class="text-center"> {{ $report->created_at->diffforhumans() }} </td>
                            <td class="text-center">
                                <a href="{{ route('user_reports.show', $report->id) }}" class="btn btn-success" data-popup="tooltip" title="{{ trans('dash.show_data') }}"><i class="fa fa-tv"></i></a>
                                <a data-popup="tooltip" title="{{ trans('dash.delete_data') }}" onclick="sweet_delete( '{{ route('user_reports.destroy', $report->id) }}', {{ $report->id }} )" class="btn btn-danger" > <i class="icon-bin2"></i> </a>
                            </td>
                        </tr>
                        <?php $count++;?>
                        @empty
                        @endforelse
                        
                    </tbody>
                </table>
            </div>
            <div id="orders" class="tab-pane fade">
                tab three
            </div>
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