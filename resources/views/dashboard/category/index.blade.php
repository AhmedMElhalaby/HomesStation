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
        <h5 class="panel-title"> {{ trans('dash.categories') }} </h5>        
    </div>

    <a class="btn btn-primary" href="{{ route('category.create') }}"> {{ trans('dash.add_new_category') }} </a>

    <table class="table table-condensed table-hover datatable-highlight">
        <thead>
            <tr>
                <th class="text-center"> # </th>
                <th class="text-center"> {{ trans('dash.image') }} </th>
                <th class="text-center"> {{ trans('dash.name_ar') }} </th>
                <th class="text-center"> {{ trans('dash.name_en') }} </th>
                <th class="text-center"> {{ trans('dash.type') }} </th>
                <th class="text-center"> {{ trans('dash.created_at') }} </th>
                <th class="text-center"> {{ trans('dash.actions') }} </th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1;?>
            @forelse($categories as $category)
            <tr id="row_{{ $category->id }}">
                <td class="text-center"> {{ $count }} </td>
                <td> <img width="100px" class="img-thumbnail" src="{{ $category->image200 }}" /> </td>
                <td class="text-center"> {{ $category->name_ar }} </td>
                <td class="text-center"> {{ $category->name_en }} </td>
                <td class="text-center">
                    @if($category->type == 'products')
                        products - منتجات
                    @else
                        services - خدمات
                    @endif
                </td>
                <td class="text-center"> {{ $category->created_at->diffforhumans() }} </td>
                <td class="text-center">
                    <a data-popup="tooltip" title="{{ trans('dash.edit_data') }}" href="{{ route('category.edit',['id' => $category->id ]) }}" class="btn btn-primary"> <i class="icon-pencil3"></i> </a>
                    <a data-popup="tooltip" title="{{ trans('dash.delete_data') }}" onclick="sweet_delete( '{{ route('category.destroy', $category->id) }}', {{ $category->id }} )" class="btn btn-danger" > <i class="icon-bin2"></i> </a>
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