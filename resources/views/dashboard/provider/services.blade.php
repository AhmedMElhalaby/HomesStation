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
        <h5 class="panel-title"> {{ $provider->username }} : {{ trans('dash.services') }} </h5>        
    </div>
    <a class="btn btn-primary" href="{{ route('provider.index') }}"> {{ trans('dash.back_to_menu') }} </a>
    <table class="table table-condensed table-hover datatable-highlight">
        <thead>
            <tr>
                <th class="text-center"> # </th>
                <th class="text-center"> {{ trans('dash.image') }} </th>
                <th class="text-center"> {{ trans('dash.name') }} </th>
                <th class="text-center"> {{ trans('dash.price') }} </th>
                <th class="text-center"> {{ trans('dash.offer') }} </th>
                <th class="text-center"> {{ trans('dash.created_at') }} </th>
                {{--  <th class="text-center"> {{ trans('dash.actions') }} </th>  --}}
            </tr>
        </thead>
        <tbody>
            <?php $count = 1;?>
            @forelse($services as $service)
            <tr id="row_{{ $service->id }}">
                <td class="text-center"> {{ $count }} </td>
                @if(count($service->Images) > 0)
                    <td> <img width="100px" class="img-thumbnail" src="{{ $service->Images[0]->image200 }}" /> </td>
                @else
                    <td> <img width="100px" class="img-thumbnail" src="{{ asset('storage/app/uploads/default.png') }}" /> </td>
                @endif
                <td class="text-center"> {{ $service->name }} </td>
                <td class="text-center"> {{ $service->price }} </td>
                <td class="text-center"> 
                    @if($service->has_offer == 'on')
                        <span class="label bg-success-400">{{ trans('dash.has_offer') }}</span>
                    @else
                        <span class="label bg-warning-400">{{ trans('dash.has_not_offer') }}</span>
                    @endif
                </td>
                <td class="text-center"> {{ $service->created_at->diffforhumans() }} </td>
                {{--  <td class="text-center">
                    <a data-popup="tooltip" title="{{ trans('dash.edit_data') }}" href="{{ route('service.edit',['id' => $service->id ]) }}" class="btn btn-primary"> <i class="icon-pencil3"></i> </a>
                </td>  --}}
            </tr>
            <?php $count++;?>
            @empty
            @endforelse            
        </tbody>
    </table>
</div>
@endsection